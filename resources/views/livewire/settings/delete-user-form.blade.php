<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="mt-8">
    <button x-data x-on:click="$dispatch('open-modal', 'confirm-user-deletion')" 
        class="w-full py-4 rounded-2xl bg-white dark:bg-pos-card-grey border-2 border-pos-error/20 text-pos-error font-black text-xs uppercase tracking-widest hover:bg-pos-error hover:text-white hover:border-pos-error transition-all shadow-sm active:scale-95">
        Hapus Akun Permanen
    </button>

    <!-- Modal Konfirmasi -->
    <div x-data="{ open: false, showPass: false }" 
         x-on:open-modal.window="if($event.detail === 'confirm-user-deletion') open = true"
         x-on:close-modal.window="open = false"
         x-show="open" 
         class="fixed inset-0 z-[999] flex items-center justify-center p-4"
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="$dispatch('close')"></div>
        
         <!-- Modal Content -->
        <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
             <div class="p-10 border-b border-pos-border dark:border-zinc-800 bg-pos-error/5 dark:bg-pos-error/10 flex items-center gap-6">
                <div class="size-16 rounded-[24px] bg-white dark:bg-pos-card-grey border border-pos-error/20 dark:border-pos-error/40 shadow-sm flex items-center justify-center text-pos-error">
                    <i data-lucide="shield-alert" class="size-8"></i>
                </div>
                <div>
                    <h3 class="font-black text-xl text-pos-foreground tracking-tight">Konfirmasi Keamanan</h3>
                    <p class="text-[10px] text-pos-error font-black uppercase tracking-widest mt-1">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <form wire:submit="deleteUser" class="p-10 space-y-8">
                <p class="text-sm font-medium text-pos-secondary leading-relaxed px-2">
                    Untuk melanjutkan penghapusan akun, silakan masukkan password Anda sebagai bentuk verifikasi akhir. Semua data cafe Anda akan dihapus secara permanen.
                </p>

                <div class="space-y-3">
                    <label class="text-[11px] font-black text-pos-secondary uppercase tracking-[0.2em] ml-1">Password Verifikasi</label>
                     <div class="relative group">
                        <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 size-5 text-pos-secondary group-focus-within:text-pos-error transition-colors"></i>
                        <input :type="showPass ? 'text' : 'password'" 
                               wire:model="password" 
                               required 
                               placeholder="Masukkan password Anda" 
                               class="w-full h-16 pl-14 pr-14 rounded-[24px] bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-pos-error/20 outline-none text-pos-foreground font-bold text-base transition-all">
                        <button type="button" @click="showPass = !showPass" class="absolute right-5 top-1/2 -translate-y-1/2 text-pos-secondary hover:text-pos-foreground transition-colors">
                            <i :data-lucide="showPass ? 'eye-off' : 'eye'" class="size-5"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-[10px] font-bold text-pos-error ml-2">{{ $message }}</span> @enderror
                </div>

                 <div class="pt-6 border-t border-pos-border dark:border-zinc-800 grid grid-cols-2 gap-4">
                    <button type="button" @click="open = false" class="py-5 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-[24px] font-black text-sm hover:bg-pos-border dark:hover:bg-pos-muted transition-all">
                        Batalkan
                    </button>
                    <button type="submit" class="py-5 bg-pos-error text-white rounded-[24px] font-black text-sm hover:bg-pos-error/90 shadow-xl shadow-pos-error/20 transition-all active:scale-95">
                        Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .animate-peek { animation: peek 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes peek {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
    </style>
</div>
