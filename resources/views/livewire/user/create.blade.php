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
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Tambah Karyawan</h1>
            <p class="text-pos-secondary font-medium mt-1">Berikan akses ke sistem untuk anggota tim baru.</p>
        </div>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 lg:p-12 border border-pos-border dark:border-zinc-800 shadow-sm">
            <form wire:submit.prevent="save" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Field: Name -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" wire:model.live="name" placeholder="Nama Karyawan" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                                <i data-lucide="user" class="size-5"></i>
                            </div>
                        </div>
                        @error('name') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Field: Email -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Alamat Email</label>
                        <div class="relative">
                            <input type="email" wire:model.live="email" placeholder="email@essycoff.com" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                                <i data-lucide="mail" class="size-5"></i>
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
                                <i data-lucide="chevron-down" class="size-4"></i>
                            </div>
                        </div>
                        @error('role') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Field: Password -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Password</label>
                        <div class="relative">
                            <input type="password" wire:model="password" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                                <i data-lucide="lock" class="size-5"></i>
                            </div>
                        </div>
                        @error('password') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Field: Password Confirmation -->
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" wire:model="password_confirmation" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                                <i data-lucide="shield-check" class="size-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Info Box -->
                <div class="p-6 bg-primary-blue/5 rounded-3xl border border-primary-blue/10 dark:border-primary-blue/20 flex gap-4 items-start">
                    <div class="size-10 rounded-xl bg-white dark:bg-pos-card-grey flex items-center justify-center text-primary-blue shrink-0 shadow-sm border border-primary-blue/5 dark:border-zinc-800">
                        <i data-lucide="shield-alert" class="size-5"></i>
                    </div>
                    <div class="pt-1">
                        <h6 class="text-xs font-black text-pos-foreground uppercase tracking-widest mb-1">Keamanan Akun</h6>
                        <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Manager memiliki akses penuh ke laporan penjualan, sedangkan Cashier hanya memiliki akses ke layar POS dan riwayat transaksi harian.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="flex-1 h-14 rounded-2xl bg-primary-blue text-white font-black text-sm uppercase tracking-widest hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="plus" class="size-5"></i>
                         <span>Daftarkan Karyawan</span>
                    </button>
                    <a href="{{ route('users.index') }}" class="px-8 h-14 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-black text-sm uppercase tracking-widest hover:bg-pos-border dark:hover:bg-pos-muted transition-all flex items-center justify-center" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
