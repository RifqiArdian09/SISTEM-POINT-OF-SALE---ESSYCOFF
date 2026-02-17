<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="tag" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Organisasi Menu</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Kategori Produk</h1>
            <p class="text-pos-secondary font-medium mt-1">Kelompokkan menu Anda untuk navigasi yang lebih cepat di POS.</p>
        </div>
        
        <a href="{{ route('categories.create') }}" 
            class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-primary-blue text-white font-bold text-sm hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95" 
            wire:navigate>
            <i data-lucide="plus-circle" class="size-5"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <!-- Categories Grid/Table -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
             <table class="w-full text-left">
                <thead class="bg-pos-card-grey/50 dark:bg-pos-muted/10">
                    <tr>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest w-24 text-center">No</th>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Nama Kategori</th>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pos-border dark:divide-zinc-800">
                    @forelse ($categories as $index => $category)
                        <tr class="hover:bg-pos-muted/20 dark:hover:bg-pos-muted/5 transition-colors group">
                            <td class="px-10 py-6 text-center">
                                <span class="size-8 inline-flex items-center justify-center rounded-lg bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary font-black text-xs">{{ $index + 1 }}</span>
                            </td>
                            <td class="px-10 py-6">
                                <h5 class="text-base font-black text-pos-foreground capitalize group-hover:text-primary-blue transition-colors">{{ $category->name }}</h5>
                            </td>
                            <td class="px-10 py-6">
                                 <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('categories.edit', $category) }}" 
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-bold text-xs hover:bg-primary-blue hover:text-white transition-all group/btn" 
                                        wire:navigate>
                                        <i data-lucide="edit-2" class="size-4"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button wire:click="confirmDelete({{ $category->id }})" 
                                        class="size-10 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:bg-pos-error hover:text-white transition-all">
                                        <i data-lucide="trash-2" class="size-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="3" class="px-10 py-20 text-center text-pos-secondary/30">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-20 bg-pos-muted dark:bg-pos-muted/20 rounded-full flex items-center justify-center">
                                        <i data-lucide="tags" class="size-10"></i>
                                    </div>
                                    <p class="font-black">Belum ada kategori terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($categories, 'hasPages') && $categories->hasPages())
            <div class="px-10 py-6 bg-pos-card-grey/30 dark:bg-pos-muted/10 border-t border-pos-border dark:border-zinc-800 flex items-center justify-between">
                <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">Total <span class="text-primary-blue">{{ $categories->total() }}</span> Kategori</p>
                {{ $categories->links('components.pagination.premium') }}
            </div>
        @endif
    </div>

     <!-- Modal Konfirmasi Hapus -->
    @if($confirmingCategoryDeletion)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="$set('confirmingCategoryDeletion', false)"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-sm p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="size-20 bg-pos-error/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="alert-triangle" class="size-10 text-pos-error"></i>
                </div>
                <h3 class="text-2xl font-black text-pos-foreground mb-3 tracking-tight">Hapus Kategori?</h3>
                <p class="text-pos-secondary text-sm font-medium mb-8">Produk dalam kategori ini tetap aman, namun label kategorinya akan dihapus.</p>
                
                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="$set('confirmingCategoryDeletion', false)" class="py-4 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-extrabold text-sm hover:bg-pos-border dark:hover:bg-pos-muted transition-all">Batal</button>
                    <button wire:click="delete({{ $categoryIdToDelete }})" class="py-4 bg-pos-error text-white rounded-2xl font-extrabold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20">Hapus</button>
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