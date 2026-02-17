<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Profil Diperbarui',
            'message' => 'Informasi profil Anda berhasil disimpan.'
        ]);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="user-circle" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Akun Personal</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Profil Pengguna</h1>
            <p class="text-pos-secondary font-medium mt-1">Kelola informasi publik dan identitas Anda di dalam sistem.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Left Side: Profile Info Card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-pos-border dark:border-zinc-800 bg-pos-card-grey/30 dark:bg-pos-muted/10">
                    <h3 class="font-black text-lg text-pos-foreground tracking-tight">Informasi Dasar</h3>
                    <p class="text-xs text-pos-secondary font-bold uppercase tracking-widest mt-1">Detail identitas login Anda</p>
                </div>
                
                <form wire:submit="updateProfileInformation" class="p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name Field -->
                         <div class="space-y-2">
                            <label class="text-[11px] font-black text-pos-secondary uppercase tracking-widest ml-1">Nama Lengkap</label>
                            <div class="relative group">
                                <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary group-focus-within:text-primary-blue transition-colors"></i>
                                <input type="text" wire:model="name" required class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-sm transition-all">
                            </div>
                            @error('name') <span class="text-[10px] font-bold text-pos-error ml-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email Field -->
                         <div class="space-y-2">
                            <label class="text-[11px] font-black text-pos-secondary uppercase tracking-widest ml-1">Alamat Email</label>
                            <div class="relative group">
                                <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary group-focus-within:text-primary-blue transition-colors"></i>
                                <input type="email" wire:model="email" required class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-sm transition-all">
                            </div>
                            @error('email') <span class="text-[10px] font-bold text-pos-error ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                        <div class="p-6 rounded-2xl bg-pos-warning/5 border border-pos-warning/20">
                            <div class="flex items-start gap-4">
                                <i data-lucide="alert-circle" class="size-6 text-pos-warning mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-black text-pos-foreground">Email belum diverifikasi.</p>
                                    <button wire:click.prevent="resendVerificationNotification" class="text-[11px] font-black text-primary-blue uppercase tracking-widest mt-2 hover:underline">
                                        Klik di sini untuk kirim ulang email verifikasi
                                    </button>
                                </div>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <p class="text-[10px] font-black text-pos-success uppercase tracking-widest mt-4">Tautan verifikasi baru telah dikirim.</p>
                            @endif
                        </div>
                    @endif

                     <div class="pt-6 border-t border-pos-border dark:border-zinc-800 flex items-center gap-4">
                        <button type="submit" class="flex items-center gap-3 px-10 py-4 rounded-2xl bg-primary-blue text-white font-black text-sm hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95">
                            <i data-lucide="save" class="size-5"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                        
                        <div x-data="{ shown: false, timeout: null }" 
                             x-on:profile-updated.window="shown = true; clearTimeout(timeout); timeout = setTimeout(() => { shown = false }, 2000)"
                             x-show="shown"
                             x-transition.out.opacity.duration.1500ms
                             class="text-xs font-bold text-pos-success flex items-center gap-2">
                            <i data-lucide="check-circle" class="size-4"></i>
                            <span>Data tersimpan!</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Account Summary/Actions -->
        <div class="space-y-8">
             <!-- Summary Card -->
            <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm text-center">
                <div class="size-24 rounded-3xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center mx-auto mb-6 text-primary-blue border border-primary-blue/10 relative">
                    <span class="text-3xl font-black uppercase">{{ auth()->user()->initials() }}</span>
                    <div class="absolute -bottom-2 -right-2 size-8 bg-pos-success rounded-xl flex items-center justify-center text-white border-4 border-white dark:border-pos-card-grey">
                        <i data-lucide="check" class="size-4"></i>
                    </div>
                </div>
                <h3 class="text-xl font-black text-pos-foreground capitalize">{{ $name }}</h3>
                <p class="text-xs font-black text-pos-secondary uppercase tracking-[0.2em] mt-1">{{ auth()->user()->role }}</p>
                
                 <div class="mt-8 pt-8 border-t border-pos-border dark:border-zinc-800 grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border border-pos-border dark:border-zinc-800 text-left">
                        <p class="text-[9px] font-black text-pos-secondary uppercase tracking-widest mb-1">Status</p>
                        <span class="text-xs font-black text-pos-success uppercase">Aktif</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border border-pos-border dark:border-zinc-800 text-left">
                        <p class="text-[9px] font-black text-pos-secondary uppercase tracking-widest mb-1">Akses</p>
                        <span class="text-xs font-black text-primary-blue uppercase">{{ auth()->user()->role }}</span>
                    </div>
                </div>
            </div>

            <!-- Warning Area -->
            <div class="bg-pos-error/5 rounded-[40px] p-8 border border-pos-error/20">
                <div class="flex items-center gap-3 mb-4">
                    <i data-lucide="shield-alert" class="size-6 text-pos-error"></i>
                    <h4 class="font-black text-base text-pos-error tracking-tight">Privasi Akun</h4>
                </div>
                <p class="text-xs font-medium text-pos-secondary leading-relaxed mb-6">Penghapusan akun bersifat permanen dan akan menghapus semua data akses Anda dari sistem EssyCoff.</p>
                
                <livewire:settings.delete-user-form />
            </div>
        </div>
    </div>
</div>
