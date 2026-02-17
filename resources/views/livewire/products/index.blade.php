<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="package" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Manajemen Inventaris</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Daftar Produk</h1>
            <p class="text-pos-secondary font-medium mt-1">Total <span class="text-pos-foreground font-bold">{{ $products->total() }}</span> produk tersedia dalam katalog.</p>
        </div>
        
        @if(!in_array($filter, ['out_of_stock', 'low_stock']))
            <a href="{{ route('products.create') }}" 
                class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-primary-blue text-white font-bold text-sm hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95" 
                wire:navigate>
                <i data-lucide="plus-circle" class="size-5"></i>
                <span>Tambah Produk Baru</span>
            </a>
        @endif
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-6 border border-pos-border dark:border-zinc-800 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary"></i>
            <input type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Cari produk berdasarkan nama atau kategori..." 
                class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground placeholder:text-pos-secondary/70 font-bold text-sm">
        </div>
        <div class="flex items-center gap-2 p-1 bg-pos-muted/50 dark:bg-pos-muted/10 rounded-2xl shrink-0">
            <button class="px-5 py-3 rounded-xl {{ $filter === null ? 'bg-white dark:bg-pos-card-grey text-primary-blue shadow-sm font-black' : 'text-pos-secondary font-bold hover:text-pos-foreground' }} text-xs transition-all">Semua</button>
            <button class="px-5 py-3 rounded-xl {{ $filter === 'active' ? 'bg-white dark:bg-pos-card-grey text-primary-blue shadow-sm font-black' : 'text-pos-secondary font-bold hover:text-pos-foreground' }} text-xs transition-all">Aktif</button>
            <div class="w-px h-6 bg-pos-border mx-1"></div>
            <button class="px-4 py-3 text-pos-secondary hover:text-pos-error transition-colors">
                <i data-lucide="sliders-horizontal" class="size-5"></i>
            </button>
        </div>
    </div>

    <!-- Products Table Container -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-pos-card-grey/50 dark:bg-pos-muted/10">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-center">Gambar</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Produk & Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Harga Jual</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-center">Status Stok</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pos-border dark:divide-zinc-800">
                    @forelse ($products as $index => $product)
                        <tr class="hover:bg-pos-muted/20 dark:hover:bg-pos-muted/5 transition-colors group text-sm">
                            <!-- Image -->
                            <td class="px-8 py-5">
                                <div class="flex justify-center">
                                    <div class="size-20 rounded-[28px] overflow-hidden bg-pos-muted dark:bg-pos-muted/20 border border-pos-border dark:border-zinc-800 relative group-hover:scale-110 transition-all duration-500 shadow-sm group-hover:shadow-xl group-hover:shadow-primary-blue/10">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->name }}" loading="lazy">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-pos-secondary/20 bg-pos-muted/50">
                                                <i data-lucide="coffee" class="size-8"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-[28px]"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Info -->
                            <td class="px-8 py-5">
                                <div>
                                    <h5 class="text-base font-black text-pos-foreground capitalize group-hover:text-primary-blue transition-colors">{{ $product->name }}</h5>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-extrabold text-primary-blue bg-primary-blue/5 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                            {{ $product->category?->name ?? 'Tanpa Kategori' }}
                                        </span>
                                        @if($product->stock <= 5)
                                            <span class="text-[10px] font-extrabold text-pos-error bg-pos-error/5 px-2 py-0.5 rounded-md uppercase tracking-wider">Tinggal Sedikit</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Price -->
                            <td class="px-8 py-5 text-right">
                                <span class="text-lg font-black text-pos-foreground font-sans">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>

                            <!-- Stock Status -->
                            <td class="px-8 py-5">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="w-16 h-1.5 bg-pos-muted rounded-full overflow-hidden">
                                        <div class="h-full {{ $product->stock > 10 ? 'bg-pos-success' : ($product->stock > 0 ? 'bg-pos-warning' : 'bg-pos-error') }}" 
                                            style="width: {{ min(($product->stock / 20) * 100, 100) }}%"></div>
                                    </div>
                                    <span class="text-[11px] font-black {{ $product->stock > 10 ? 'text-pos-success' : ($product->stock > 0 ? 'text-pos-warning' : 'text-pos-error') }}">
                                        {{ $product->stock }} <span class="uppercase opacity-60">Stok</span>
                                    </span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}" 
                                        class="size-11 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:bg-primary-blue hover:text-white hover:shadow-lg hover:shadow-primary-blue/20 transition-all group/btn" 
                                        wire:navigate>
                                        <i data-lucide="edit-3" class="size-5"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $product->id }})" 
                                        class="size-11 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:bg-pos-error hover:text-white hover:shadow-lg hover:shadow-pos-error/20 transition-all">
                                        <i data-lucide="trash-2" class="size-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-pos-secondary/30">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-20 bg-pos-muted rounded-full flex items-center justify-center">
                                        <i data-lucide="package-search" class="size-10"></i>
                                    </div>
                                    <div>
                                        <p class="text-lg font-black text-pos-foreground/50">Produk Tidak Ditemukan</p>
                                        <p class="text-sm font-medium">Coba gunakan kata kunci lain atau tambah produk baru</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="px-8 py-6 bg-pos-card-grey/30 dark:bg-pos-muted/10 border-t border-pos-border dark:border-zinc-800 flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">
                    Menampilkan <span class="text-pos-foreground">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> dari <span class="text-primary-blue">{{ $products->total() }}</span> Katalog
                </p>
                {{ $products->links('components.pagination.premium') }}
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus -->
    @if($confirmingProductDeletion)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="$set('confirmingProductDeletion', false)"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-sm p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="size-20 bg-pos-error/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="alert-octagon" class="size-10 text-pos-error"></i>
                </div>
                <h3 class="text-2xl font-black text-pos-foreground mb-3 tracking-tight">Hapus Produk?</h3>
                <p class="text-pos-secondary text-sm font-medium mb-8 leading-relaxed">Tindakan ini akan menghapus data <span class="text-pos-error font-bold">secara permanen</span> dari katalog dan sistem inventaris Anda.</p>
                
                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="$set('confirmingProductDeletion', false)" class="py-4 bg-pos-muted text-pos-foreground rounded-2xl font-extrabold text-sm hover:bg-pos-border transition-all">Batal</button>
                    <button wire:click="delete({{ $productIdToDelete }})" class="py-4 bg-pos-error text-white rounded-2xl font-extrabold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20">Ya, Hapus</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-peek { animation: peek 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes peek {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
    </style>
</div>