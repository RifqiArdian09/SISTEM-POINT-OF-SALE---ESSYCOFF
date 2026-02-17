
<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\User;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = true;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Validate credentials without logging in yet
        $credentials = ['email' => $this->email, 'password' => $this->password];
        if (! Auth::validate($credentials)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Fetch user and enforce single active session
        $user = User::where('email', $this->email)->first();
        if ($user && !empty($user->active_session_id) && $user->active_session_id !== Session::getId()) {
            // Another device is already using this account
            throw ValidationException::withMessages([
                'email' => 'Akun ini sedang aktif di perangkat lain. Silakan keluar dari perangkat tersebut terlebih dahulu.',
            ]);
        }

        // Proceed with normal login
        if (! Auth::attempt($credentials, $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Store the new session ID as the active session for the user
        $user = Auth::user();
        try {
            $user->active_session_id = Session::getId();
            $user->save();
        } catch (\Throwable $e) {
            Log::error('Failed to set active_session_id for user ID '.$user->id.': '.$e->getMessage());
        }
        
        // Direct redirect based on role
        if ($user->role === 'cashier') {
            $this->redirect(route('pos.cashier'), navigate: true);
        } else {
            $this->redirect(route('dashboard'), navigate: true);
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>


<div class="flex flex-col gap-10">
    <!-- Header Section -->
    <div class="space-y-6">
        
        
        <div class="space-y-2">
            <h2 class="text-4xl font-black text-pos-foreground tracking-tight">Login.</h2>
            <p class="text-pos-secondary font-medium text-lg leading-relaxed">
                Kelola bisnis kopimu dengan lebih mudah.<br>
                <span class="text-pos-foreground">Silakan masuk ke akun Anda.</span>
            </p>
        </div>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="p-4 bg-primary-blue/10 border border-primary-blue/20 rounded-2xl">
            <p class="text-sm font-bold text-primary-blue">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" wire:submit="login" class="flex flex-col gap-8">
        <div class="space-y-5">
            <!-- Email Address -->
            <div class="space-y-2">
                <div class="flex justify-between items-center px-1">
                    <label for="email" class="text-sm font-black text-pos-foreground uppercase tracking-widest">{{ __('Email') }}</label>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="mail" class="size-5 text-pos-secondary group-focus-within:text-primary-blue transition-colors"></i>
                    </div>
                    <input 
                        id="email" 
                        type="email" 
                        wire:model="email" 
                        placeholder="Masukkan email Anda" 
                        class="w-full bg-pos-muted/50 dark:bg-pos-border/20 border-2 border-transparent focus:border-primary-blue focus:bg-white dark:focus:bg-pos-card-grey rounded-2xl py-4 pl-12 pr-4 text-pos-foreground font-bold placeholder:text-pos-secondary placeholder:font-medium transition-all outline-none"
                        required 
                        autofocus
                    >
                </div>
                @error('email')
                    <p class="text-xs font-bold text-pos-error mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="size-3"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center px-1">
                    <label for="password" class="text-sm font-black text-pos-foreground uppercase tracking-widest">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary-blue hover:underline">Lupa Password?</a>
                    @endif
                </div>
                <div class="relative group" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="size-5 text-pos-secondary group-focus-within:text-primary-blue transition-colors"></i>
                    </div>
                    <input 
                        :type="show ? 'text' : 'password'" 
                        id="password" 
                        wire:model="password" 
                        placeholder="••••••••" 
                        class="w-full bg-pos-muted/50 dark:bg-pos-border/20 border-2 border-transparent focus:border-primary-blue focus:bg-white dark:focus:bg-pos-card-grey rounded-2xl py-4 pl-12 pr-12 text-pos-foreground font-bold placeholder:text-pos-secondary placeholder:font-medium transition-all outline-none"
                        required
                    >
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-pos-secondary hover:text-pos-foreground transition-colors">
                        <i x-show="!show" data-lucide="eye" class="size-5"></i>
                        <i x-show="show" data-lucide="eye-off" class="size-5"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs font-bold text-pos-error mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="size-3"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Remember Me & Extra Info -->
        <div class="flex items-center justify-between px-1">
            <label class="flex items-center gap-3 cursor-pointer group">
                <div class="relative">
                    <input type="checkbox" wire:model="remember" class="peer sr-only">
                    <div class="size-6 bg-pos-muted dark:bg-pos-border/50 border-2 border-pos-border rounded-lg peer-checked:bg-primary-blue peer-checked:border-primary-blue transition-all group-hover:scale-105"></div>
                    <i data-lucide="check" class="absolute inset-0 size-4 m-auto text-white scale-0 peer-checked:scale-100 transition-transform"></i>
                </div>
                <span class="text-sm font-bold text-pos-secondary group-hover:text-pos-foreground transition-colors">Ingatkan Saya</span>
            </label>
        </div>

      <!-- Login Button -->
<button
    type="submit"
    class="group relative w-full 
           bg-slate-900 dark:bg-white 
           text-white dark:text-slate-900 
           font-bold text-lg py-5 rounded-2xl 
           shadow-xl shadow-black/10 dark:shadow-white/10
           hover:bg-blue-600 dark:hover:bg-blue-600
           hover:text-white
           transition-all duration-300 
           active:scale-[0.98] overflow-hidden">

    <div class="relative z-10 flex items-center justify-center gap-3">
        <span>{{ __('Log in') }}</span>
        <i data-lucide="arrow-right"
           class="size-6 group-hover:translate-x-1 transition-transform"></i>
    </div>

    <div class="absolute inset-0 
                bg-gradient-to-r 
                from-transparent via-white/10 dark:via-black/10 to-transparent 
                -translate-x-full group-hover:translate-x-full 
                transition-transform duration-1000"></div>
</button>

    </form>
</div>