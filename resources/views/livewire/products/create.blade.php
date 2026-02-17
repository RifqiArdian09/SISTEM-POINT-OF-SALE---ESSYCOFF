<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('products.index') }}" class="text-xs font-black text-pos-secondary hover:text-primary-blue uppercase tracking-widest transition-colors flex items-center gap-1" wire:navigate>
                    <i data-lucide="arrow-left" class="size-3"></i>
                    Kembali ke Daftar
                </a>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Tambah Produk</h1>
            <p class="text-pos-secondary font-medium mt-1">Daftarkan menu atau item baru ke dalam katalog EssyCoff.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Left: Form -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 lg:p-12 border border-pos-border dark:border-zinc-800 shadow-sm">
                <form wire:submit.prevent="save" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Field: Name -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Nama Produk</label>
                            <input type="text" wire:model.live="name" placeholder="Contoh: Cappuccino Hot" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            @error('name') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Field: Category -->
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Kategori</label>
                            <div class="relative">
                                <select wire:model.live="category_id" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20 appearance-none">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-pos-secondary">
                                    <i data-lucide="chevron-down" class="size-4"></i>
                                </div>
                            </div>
                            @error('category_id') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Field: Price -->
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Harga Jual (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-pos-foreground">Rp</span>
                                <input type="number" wire:model.live="price" class="w-full h-14 pl-14 pr-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-black text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                            </div>
                            @error('price') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Field: Stock -->
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Stok Awal</label>
                            <div class="relative">
                                <input type="number" wire:model.live="stock" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-pos-secondary font-black text-[10px] uppercase">Porsi</div>
                            </div>
                            @error('stock') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Field: Image Upload -->
                     <div class="space-y-4">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Foto Produk</label>
                        <div class="relative group">
                            <input type="file" wire:model="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full h-32 rounded-[28px] border-2 border-dashed border-pos-border dark:border-zinc-800 bg-pos-muted/50 dark:bg-pos-muted/5 flex flex-col items-center justify-center gap-2 group-hover:border-primary-blue/30 group-hover:bg-primary-blue/5 transition-all">
                                <div class="size-10 rounded-xl bg-white dark:bg-pos-card-grey flex items-center justify-center text-pos-secondary shadow-sm group-hover:text-primary-blue">
                                    <i data-lucide="cloud-upload" class="size-6"></i>
                                </div>
                                <p class="text-xs font-bold text-pos-secondary">Klik atau tarik foto ke sini</p>
                                <p class="text-[9px] font-black text-pos-secondary/40 uppercase tracking-tighter">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                        @error('image') <span class="text-[10px] font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="flex-1 h-14 rounded-2xl bg-primary-blue text-white font-black text-sm uppercase tracking-widest hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                             <i data-lucide="check" class="size-5"></i>
                            <span>Simpan Produk</span>
                        </button>
                        <a href="{{ route('products.index') }}" class="px-8 h-14 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-black text-sm uppercase tracking-widest hover:bg-pos-border dark:hover:bg-pos-muted transition-all flex items-center justify-center" wire:navigate>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Preview Card -->
        <div class="space-y-6">
            <div class="sticky top-10">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1 mb-4 block">Live Preview</label>
                <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-4 border border-pos-border dark:border-zinc-800 shadow-xl relative overflow-hidden group max-w-[280px] mx-auto">
                    <!-- Ribbon status -->
                    <div class="absolute top-4 left-4 z-20">
                        <span class="px-2 py-1 bg-pos-success text-white text-[8px] font-black uppercase tracking-widest rounded-lg shadow-sm">Baru</span>
                    </div>

                    <!-- Image Area -->
                    <div class="aspect-square rounded-[24px] bg-pos-muted dark:bg-pos-muted/20 overflow-hidden mb-4 relative">
                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-pos-secondary/20">
                                <i data-lucide="image" class="size-12 mb-2"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="px-2 py-2">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-black text-pos-foreground truncate pr-4">{{ $name ?: 'Nama Produk' }}</h4>
                            <span class="size-2 rounded-full bg-pos-success"></span>
                        </div>
                        <p class="text-[10px] font-black text-primary-blue/60 uppercase tracking-widest mb-3">
                            {{ $category_id ? $categories->find($category_id)->name : 'Kategori' }}
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-base font-black text-pos-foreground font-sans">Rp {{ number_format((float)($price ?: 0), 0, ',', '.') }}</span>
                            <div class="size-8 rounded-lg bg-primary-blue/10 text-primary-blue flex items-center justify-center">
                                <i data-lucide="plus" class="size-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="mt-8 p-6 bg-primary-blue/5 rounded-3xl border border-primary-blue/10 dark:border-primary-blue/20">
                    <div class="flex gap-4 items-start">
                        <div class="size-10 rounded-xl bg-white dark:bg-pos-card-grey flex items-center justify-center text-primary-blue shrink-0 shadow-sm border border-primary-blue/5 dark:border-zinc-800">
                            <i data-lucide="info" class="size-5"></i>
                        </div>
                        <div>
                            <h6 class="text-xs font-black text-pos-foreground uppercase tracking-widest mb-1">Tips Unggahan</h6>
                            <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Gunakan foto dengan latar belakang minimalis atau transparan untuk hasil terbaik di aplikasi Kasir.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>