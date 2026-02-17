<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Password Berhasil Diubah',
            'message' => 'Keamanan akun Anda telah ditingkatkan.'
        ]);
    }
}; ?>

<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-pos-error/10 rounded-lg flex items-center justify-center text-pos-error">
                    <i data-lucide="shield-alert" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-pos-error uppercase tracking-widest">Keamanan Sistem</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Perbarui Password</h1>
            <p class="text-pos-secondary font-medium mt-1">Gunakan kombinasi karakter yang kuat untuk menjaga privasi akses Anda.</p>
        </div>
    </div>

    <!-- Centered Form Layout -->
    <div class="flex justify-start" x-data="{ showOld: false, showNew: false, showConfirm: false }">
        <div class="w-full max-w-2xl bg-white dark:bg-pos-card-grey rounded-[48px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
             <div class="p-10 border-b border-pos-border dark:border-zinc-800 bg-pos-card-grey/30 dark:bg-pos-muted/10 flex items-center gap-6">
                <div class="size-16 rounded-[24px] bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 shadow-sm flex items-center justify-center text-pos-error">
                    <i data-lucide="key-round" class="size-8"></i>
                </div>
                <div>
                    <h3 class="font-black text-xl text-pos-foreground tracking-tight">Kredensial Keamanan</h3>
                    <p class="text-xs text-pos-secondary font-bold uppercase tracking-widest mt-1">Verifikasi password lama sebelum mengubah</p>
                </div>
            </div>
            
            <form wire:submit="updatePassword" class="p-12 space-y-10">
                <div class="space-y-8">
                    <!-- Current Password -->
                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-pos-secondary uppercase tracking-[0.2em] ml-1">Password Saat Ini</label>
                         <div class="relative group">
                            <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 size-5 text-pos-secondary group-focus-within:text-pos-error transition-colors"></i>
                            <input :type="showOld ? 'text' : 'password'" wire:model="current_password" required placeholder="••••••••" class="w-full h-16 pl-14 pr-14 rounded-[24px] bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-pos-error/20 outline-none text-pos-foreground font-bold text-base transition-all">
                            <button type="button" @click="showOld = !showOld" class="absolute right-5 top-1/2 -translate-y-1/2 text-pos-secondary hover:text-pos-foreground transition-colors">
                                <i :data-lucide="showOld ? 'eye-off' : 'eye'" class="size-5"></i>
                            </button>
                        </div>
                        @error('current_password') <span class="text-[10px] font-bold text-pos-error ml-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <!-- New Password -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-pos-secondary uppercase tracking-[0.2em] ml-1">Password Baru</label>
                             <div class="relative group">
                                <i data-lucide="shield-check" class="absolute left-5 top-1/2 -translate-y-1/2 size-5 text-pos-secondary group-focus-within:text-primary-blue transition-colors"></i>
                                <input :type="showNew ? 'text' : 'password'" wire:model="password" required placeholder="••••••••" class="w-full h-16 pl-14 pr-14 rounded-[24px] bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-base transition-all">
                                <button type="button" @click="showNew = !showNew" class="absolute right-5 top-1/2 -translate-y-1/2 text-pos-secondary hover:text-primary-blue transition-colors">
                                    <i :data-lucide="showNew ? 'eye-off' : 'eye'" class="size-5"></i>
                                </button>
                            </div>
                            @error('password') <span class="text-[10px] font-bold text-pos-error ml-2">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-pos-secondary uppercase tracking-[0.2em] ml-1">Konfirmasi</label>
                             <div class="relative group">
                                <i data-lucide="shield-check" class="absolute left-5 top-1/2 -translate-y-1/2 size-5 text-pos-secondary group-focus-within:text-primary-blue transition-colors"></i>
                                <input :type="showConfirm ? 'text' : 'password'" wire:model="password_confirmation" required placeholder="••••••••" class="w-full h-16 pl-14 pr-14 rounded-[24px] bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-base transition-all">
                                <button type="button" @click="showConfirm = !showConfirm" class="absolute right-5 top-1/2 -translate-y-1/2 text-pos-secondary hover:text-primary-blue transition-colors">
                                    <i :data-lucide="showConfirm ? 'eye-off' : 'eye'" class="size-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="pt-10 border-t border-pos-border dark:border-zinc-800 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs font-bold text-pos-secondary">
                        <i data-lucide="info" class="size-4"></i>
                        <span>Min. 8 Karakter, Huruf & Angka</span>
                    </div>

                    <div class="flex items-center gap-6">
                        <div x-data="{ shown: false, timeout: null }" 
                             x-on:password-updated.window="shown = true; clearTimeout(timeout); timeout = setTimeout(() => { shown = false }, 2000)"
                             x-show="shown"
                             x-transition.out.opacity.duration.1500ms
                             class="text-xs font-black text-pos-success uppercase tracking-widest">
                            Tersimpan!
                        </div>

                          <button type="submit" class="flex items-center gap-3 px-10 py-5 rounded-[24px] bg-pos-foreground dark:bg-primary-blue text-white font-black text-sm hover:bg-pos-foreground/90 dark:hover:bg-primary-blue-hover shadow-xl shadow-pos-foreground/20 transition-all active:scale-95">
                            <i data-lucide="refresh-cw" class="size-5"></i>
                            <span>Update Password</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
