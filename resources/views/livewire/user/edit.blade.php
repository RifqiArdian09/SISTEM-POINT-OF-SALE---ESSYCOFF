<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('users.index') }}" class="text-xs font-black text-pos-secondary hover:text-primary-blue uppercase tracking-widest transition-colors flex items-center gap-1" wire:navigate>
                    <i data-lucide="arrow-left" class="size-3"></i>
                    Kembali ke Daftar
                </a>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Edit Karyawan</h1>
            <p class="text-pos-secondary font-medium mt-1">Perbarui profil dan hak akses untuk <span class="text-primary-blue font-bold">{{ $name }}</span>.</p>
        </div>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 lg:p-12 border border-pos-border dark:border-zinc-800 shadow-sm">
            <form wire:submit.prevent="update" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Field: Name -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" wire:model.live="name" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                                <i data-lucide="user-cog" class="size-5"></i>
                            </div>
                        </div>
                        @error('name') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Field: Email -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Alamat Email</label>
                        <div class="relative">
                            <input type="email" wire:model.live="email" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                                <i data-lucide="mail-search" class="size-5"></i>
                            </div>
                        </div>
                        @error('email') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Field: Role -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Peran / Hak Akses</label>
                        <div class="relative">
                            <select wire:model.live="role" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20 appearance-none">
                                <option value="">Pilih Peran</option>
                                <option value="manager">Manager</option>
                                <option value="cashier">Cashier</option>
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-pos-secondary">
                                <i data-lucide="shield" class="size-4"></i>
                            </div>
                        </div>
                        @error('role') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="flex-1 h-14 rounded-2xl bg-primary-blue text-white font-black text-sm uppercase tracking-widest hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="refresh-ccw" class="size-5"></i>
                         <span>Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('users.index') }}" class="px-8 h-14 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-black text-sm uppercase tracking-widest hover:bg-pos-border dark:hover:bg-pos-muted transition-all flex items-center justify-center" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
