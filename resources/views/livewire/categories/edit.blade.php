<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('categories.index') }}" class="text-xs font-black text-pos-secondary hover:text-primary-blue uppercase tracking-widest transition-colors flex items-center gap-1" wire:navigate>
                    <i data-lucide="arrow-left" class="size-3"></i>
                    Kembali ke Daftar
                </a>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Edit Kategori</h1>
            <p class="text-pos-secondary font-medium mt-1">Perbarui identitas kategori untuk produk Anda.</p>
        </div>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 lg:p-12 border border-pos-border dark:border-zinc-800 shadow-sm">
            <form wire:submit.prevent="update" class="space-y-8">
                <!-- Field: Name -->
                 <div class="space-y-2">
                    <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Nama Kategori</label>
                    <div class="relative">
                        <input type="text" wire:model.live="name" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-primary-blue/30">
                            <i data-lucide="edit-3" class="size-5"></i>
                        </div>
                    </div>
                    @error('name') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                </div>

                 <!-- Info Box -->
                <div class="p-6 bg-pos-card-grey/50 dark:bg-pos-muted/10 rounded-3xl border border-pos-border dark:border-zinc-800 flex gap-4 items-start">
                    <div class="size-10 rounded-xl bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 flex items-center justify-center text-pos-secondary shrink-0 shadow-sm">
                        <i data-lucide="info" class="size-5"></i>
                    </div>
                    <div class="pt-1">
                        <h6 class="text-xs font-black text-pos-foreground uppercase tracking-widest mb-1">Catatan Perubahan</h6>
                        <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Mengubah nama kategori akan secara otomatis memperbarui semua label produk yang terhubung dengan kategori ini.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-4">
                     <button type="submit" class="flex-1 h-14 rounded-2xl bg-primary-blue text-white font-black text-sm uppercase tracking-widest hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="save" class="size-5"></i>
                        <span>Perbarui Nama</span>
                    </button>
                    <a href="{{ route('categories.index') }}" class="px-8 h-14 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-black text-sm uppercase tracking-widest hover:bg-pos-border dark:hover:bg-pos-muted transition-all flex items-center justify-center" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
