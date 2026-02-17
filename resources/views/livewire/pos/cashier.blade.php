<div class="flex flex-col lg:flex-row h-[calc(100vh-65px)] overflow-hidden bg-pos-muted dark:bg-pos-muted font-sans relative" 
    x-data="{ 
        cartOpen: false
    }"
>
    <!-- Left: Product Selection (65-70%) -->
    <div class="flex-1 flex flex-col h-full min-w-0">
        <!-- Top Bar / Search -->
        <header class="h-[70px] shrink-0 bg-white dark:bg-pos-card-grey border-b border-pos-border dark:border-zinc-800 px-6 flex items-center justify-between gap-4">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary"></i>
                    <input type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari menu..." 
                        class="w-full h-11 pl-12 pr-4 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground placeholder:text-pos-secondary/70 font-medium text-sm">
                </div>
            </div>

            <!-- Date & Time (Desktop) -->
            <div class="hidden sm:flex flex-col items-end" x-data="{ time: '', date: '', update() { let now = new Date(); this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }); this.date = now.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }); } }" x-init="update(); setInterval(() => update(), 1000)">
                <p class="font-bold text-pos-foreground text-sm" x-text="time"></p>
                <p class="text-[10px] text-pos-secondary font-medium" x-text="date"></p>
            </div>
        </header>

        <!-- Product Content Area -->
        <div class="flex-1 overflow-hidden flex flex-col p-4 md:p-6 gap-6">
            <!-- Category Tabs -->
            <div class="overflow-x-auto no-scrollbar shrink-0">
                <div class="flex items-center gap-3 pb-1">
                    <button wire:click="filterCategory(null)" 
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl border font-semibold transition-all duration-300 whitespace-nowrap {{ $categoryId === null ? 'bg-primary-blue text-white border-primary-blue shadow-lg shadow-primary-blue/25' : 'bg-white dark:bg-pos-card-grey text-pos-secondary border-transparent dark:border-zinc-800 hover:text-pos-foreground shadow-sm' }}">
                        <i data-lucide="layout-grid" class="size-4"></i>
                        <span class="text-sm">Semua Menu</span>
                    </button>
 
                    @foreach($categories as $category)
                        <button wire:click="filterCategory({{ $category->id }})" 
                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl border font-semibold transition-all duration-300 whitespace-nowrap {{ $categoryId == $category->id ? 'bg-primary-blue text-white border-primary-blue shadow-lg shadow-primary-blue/25' : 'bg-white dark:bg-pos-card-grey text-pos-secondary border-transparent dark:border-zinc-800 hover:text-pos-foreground shadow-sm' }}">
                            <span class="text-sm">{{ $category->name }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto pr-1 custom-scroll pb-20 lg:pb-6">
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($products as $product)
                        <div wire:click="addToCart({{ $product->id }})" 
                            class="group bg-white dark:bg-pos-card-grey rounded-[24px] p-3 border border-pos-border dark:border-zinc-800 hover:border-primary-blue/50 hover:shadow-xl hover:shadow-primary-blue/5 transition-all cursor-pointer flex flex-col gap-3 h-full relative"
                        >
                            <div class="aspect-square rounded-[18px] overflow-hidden bg-pos-muted dark:bg-pos-muted/20 relative">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-pos-secondary/30">
                                        <i data-lucide="image" class="size-10"></i>
                                    </div>
                                @endif
                                
                                 <div class="absolute bottom-2 right-2 size-8 bg-white dark:bg-pos-muted/80 backdrop-blur rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-opacity translate-y-2 group-hover:translate-y-0 text-primary-blue">
                                    <i data-lucide="plus" class="size-5"></i>
                                </div>

                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center backdrop-blur-[2px]">
                                        <span class="bg-pos-error text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Habis</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col flex-1 px-1">
                                <h4 class="font-bold text-pos-foreground text-sm line-clamp-2 mb-1">{{ $product->name }}</h4>
                                 <div class="mt-auto flex items-center justify-between">
                                    <span class="font-bold text-primary-blue">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-pos-secondary font-medium px-2 py-0.5 bg-pos-muted dark:bg-pos-muted/20 rounded-md capitalize">{{ $product->category?->name ?? 'Uncategorized' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                            <div class="size-16 bg-pos-muted rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="search-x" class="size-8 text-pos-secondary/50"></i>
                            </div>
                            <p class="font-medium text-pos-secondary">Produk tidak ditemukan</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8 mb-4">
                    {{ $products->links('components.pagination.premium') }}
                </div>
            </div>
        </div>
    </div>

     <!-- Right: Cart / Order Summary (30-35%) -->
    <div class="w-full lg:w-[380px] bg-white dark:bg-pos-card-grey border-l border-pos-border dark:border-zinc-800 flex flex-col h-full absolute lg:static bottom-0 translate-y-full lg:translate-y-0 transition-transform duration-300 z-30 shadow-2xl lg:shadow-none rounded-t-[32px] lg:rounded-none" 
        :class="cartOpen ? 'translate-y-0' : 'translate-y-full lg:translate-y-0'"
        id="cartPanel"
    >
        <!-- Mobile Drag Handle -->
        <div class="lg:hidden w-full flex items-center justify-center pt-3 pb-1" @click="cartOpen = false">
            <div class="w-12 h-1.5 bg-gray-200 rounded-full"></div>
        </div>

         <!-- Order Header -->
        <div class="p-6 border-b border-pos-border dark:border-zinc-800 flex items-center justify-between shrink-0">
            <div>
                <h2 class="font-bold text-xl text-pos-foreground">Pesanan Saat Ini</h2>
                <div class="flex items-center gap-2 mt-0.5">
                    <span class="text-[11px] bg-primary-blue/10 text-primary-blue px-2 py-0.5 rounded-full font-bold">POS MODE</span>
                    <span class="text-[11px] text-pos-secondary font-medium">Order #{{ $nextOrderNumber }}</span>
                </div>
            </div>
            <button wire:click="clearCartWithConfirm" class="size-10 flex items-center justify-center hover:bg-pos-error/10 text-pos-error rounded-xl transition-colors" title="Kosongkan Keranjang">
                <i data-lucide="trash-2" class="size-5"></i>
            </button>
        </div>

        <!-- Cart Items List -->
        <div class="flex-1 overflow-y-auto p-6 custom-scroll">
            @if(empty($cart))
                <div class="h-full flex flex-col items-center justify-center text-center text-pos-secondary/40">
                    <div class="size-20 bg-pos-muted rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="shopping-bag" class="size-10 opacity-50"></i>
                    </div>
                    <p class="font-bold text-sm text-pos-foreground/60">Keranjang Kosong</p>
                    <p class="text-xs mt-1 max-w-[200px]">Pilih item dari menu untuk memulai pesanan baru</p>
                </div>
            @else
                <div class="space-y-5">
                     @foreach($cart as $id => $item)
                        <div class="flex items-center gap-4 group">
                            <div class="size-16 rounded-2xl overflow-hidden bg-pos-muted dark:bg-pos-muted/20 border border-pos-border dark:border-zinc-800 shrink-0">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-cover" alt="{{ $item['name'] }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="coffee" class="size-6 text-pos-secondary/30"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="font-bold text-sm text-pos-foreground truncate">{{ $item['name'] }}</h5>
                                <p class="text-[11px] text-primary-blue font-bold mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                
                                 <div class="flex items-center gap-3 mt-2">
                                    <div class="flex items-center gap-3 bg-pos-muted/80 dark:bg-pos-muted/20 rounded-full p-1 border border-pos-border dark:border-zinc-800">
                                        <button wire:click="updateQuantity({{ $id }}, {{ $item['qty'] - 1 }})" class="size-6 rounded-full bg-white dark:bg-pos-card-grey shadow-sm flex items-center justify-center hover:bg-gray-50 text-pos-foreground cursor-pointer transition-colors border border-pos-border dark:border-zinc-800">
                                            <i data-lucide="minus" class="size-3"></i>
                                        </button>
                                        <span class="w-4 text-center text-[13px] font-bold text-pos-foreground">{{ $item['qty'] }}</span>
                                        <button wire:click="updateQuantity({{ $id }}, {{ $item['qty'] + 1 }})" class="size-6 rounded-full bg-primary-blue text-white shadow-sm flex items-center justify-center hover:bg-primary-blue-hover cursor-pointer transition-colors">
                                            <i data-lucide="plus" class="size-3"></i>
                                        </button>
                                    </div>
                                    <button wire:click="removeFromCart({{ $id }})" class="text-pos-error/60 hover:text-pos-error transition-colors">
                                        <i data-lucide="x-circle" class="size-4"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-sm text-pos-foreground">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

         <!-- Totals & Actions -->
        <div class="p-6 bg-pos-card-grey/50 dark:bg-pos-muted/10 border-t border-pos-border dark:border-zinc-800 shrink-0 space-y-4">
            <div class="space-y-2.5">
                <div class="flex justify-between text-pos-secondary text-xs font-semibold">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-pos-foreground text-xl font-bold pt-3 border-t border-pos-border/50 dark:border-zinc-800 mt-2">
                    <span>Total</span>
                    <span class="text-primary-blue">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <button wire:click="openCheckoutModal" 
                class="w-full h-14 bg-primary-blue text-white rounded-full font-bold text-base hover:bg-primary-blue-hover shadow-lg shadow-primary-blue/20 transition-all active:scale-[0.98] flex items-center justify-between px-6 disabled:opacity-50 disabled:pointer-events-none group"
                @if(empty($cart)) disabled @endif
            >
                <div class="flex items-center gap-3">
                    <i data-lucide="credit-card" class="size-5 group-hover:scale-110 transition-transform"></i>
                    <span>Bayar Sekarang</span>
                </div>
                <div class="h-8 w-px bg-white/20 mx-2"></div>
                <span class="text-sm">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </button>
        </div>
    </div>

    <!-- Floating Mobile Cart Button -->
    <button @click="cartOpen = true" class="lg:hidden fixed bottom-6 right-6 h-14 pl-6 pr-8 bg-pos-foreground text-white rounded-full shadow-2xl z-20 flex items-center gap-3 hover:scale-105 transition-transform active:scale-95">
        <div class="relative">
            <i data-lucide="shopping-bag" class="size-6"></i>
            @if(count($cart) > 0)
                <span class="absolute -top-1.5 -right-1.5 size-5 bg-pos-error text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-pos-foreground">
                    {{ array_sum(array_column($cart, 'qty')) }}
                </span>
            @endif
        </div>
        <span class="font-bold text-sm">Lihat Pesanan</span>
    </button>

    <!-- Modal: Checkout / Payment Details -->
     @if($showCheckoutModal)
    <div class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" x-data x-init="if (window.lucide) lucide.createIcons()">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closePaymentModal"></div>
        
        <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-4xl shadow-2xl overflow-hidden animate-peek border border-pos-border dark:border-zinc-800">
            <div class="px-8 py-6 border-b border-pos-border dark:border-zinc-800 flex items-center justify-between bg-pos-muted/30 dark:bg-pos-muted/10">
                <h3 class="font-black text-xl text-pos-foreground tracking-tight flex items-center gap-3">
                    <i data-lucide="wallet" class="size-6 text-primary-blue"></i>
                    Detail Pembayaran
                </h3>
                <button wire:click="closeCheckoutModal" class="p-2 hover:bg-pos-muted dark:hover:bg-pos-muted/20 rounded-full transition-colors group">
                    <i data-lucide="x" class="size-6 text-pos-secondary group-hover:text-pos-error transition-colors"></i>
                </button>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column: Payment Summary & Method -->
                <div class="space-y-6">
                    <div class="text-center bg-primary-blue/5 dark:bg-primary-blue/10 rounded-[24px] py-8 border-2 border-primary-blue/10 border-dashed">
                        <p class="text-pos-secondary text-xs font-black uppercase tracking-widest mb-2">Total Tagihan</p>
                        <h2 class="text-5xl font-black text-primary-blue tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</h2>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-pos-secondary uppercase tracking-widest px-1">Pilih Metode Pembayaran</label>
                         <div class="grid grid-cols-3 gap-3">
                            <button wire:click="$set('paymentMethod','cash')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-[20px] border-2 transition-all {{ $paymentMethod === 'cash' ? 'border-primary-blue bg-primary-blue/5' : 'border-pos-border dark:border-zinc-800 hover:border-primary-blue/30 bg-white dark:bg-pos-card-grey' }}">
                                <i data-lucide="banknote" class="size-6 {{ $paymentMethod === 'cash' ? 'text-primary-blue' : 'text-pos-secondary' }}"></i>
                                <span class="text-[11px] font-bold {{ $paymentMethod === 'cash' ? 'text-primary-blue' : 'text-pos-secondary' }}">Tunai</span>
                            </button>
                            <button wire:click="$set('paymentMethod','card')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-[20px] border-2 transition-all {{ $paymentMethod === 'card' ? 'border-primary-blue bg-primary-blue/5' : 'border-pos-border dark:border-zinc-800 hover:border-primary-blue/30 bg-white dark:bg-pos-card-grey' }}">
                                <i data-lucide="credit-card" class="size-6 {{ $paymentMethod === 'card' ? 'text-primary-blue' : 'text-pos-secondary' }}"></i>
                                <span class="text-[11px] font-bold {{ $paymentMethod === 'card' ? 'text-primary-blue' : 'text-pos-secondary' }}">Kartu</span>
                            </button>
                            <button wire:click="$set('paymentMethod','qris')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-[20px] border-2 transition-all {{ $paymentMethod === 'qris' ? 'border-primary-blue bg-primary-blue/5' : 'border-pos-border dark:border-zinc-800 hover:border-primary-blue/30 bg-white dark:bg-pos-card-grey' }}">
                                <i data-lucide="qr-code" class="size-6 {{ $paymentMethod === 'qris' ? 'text-primary-blue' : 'text-pos-secondary' }}"></i>
                                <span class="text-[11px] font-bold {{ $paymentMethod === 'qris' ? 'text-primary-blue' : 'text-pos-secondary' }}">QRIS</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Input Details -->
                <div class="flex flex-col h-full justify-between gap-6">
                    <div class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                             <div class="relative group">
                                <label class="block text-[11px] font-black text-pos-secondary uppercase tracking-widest mb-2 px-1">Pilih Meja</label>
                                <select wire:model.live="selectedTableId" class="w-full h-12 px-4 rounded-xl border-2 border-pos-border dark:border-zinc-800 focus:ring-4 focus:ring-primary-blue/10 focus:border-primary-blue outline-none font-bold text-sm text-pos-foreground appearance-none bg-white dark:bg-pos-card-grey transition-all">
                                    <option value="">Tanpa Meja (Take Away)</option>
                                    @foreach(($tables ?? collect()) as $t)
                                        @if(($t->status ?? 'available') === 'available')
                                            <option value="{{ $t->id }}">
                                                {{ $t->name }} ({{ $t->code }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-[38px] pointer-events-none text-pos-secondary group-hover:text-primary-blue transition-colors">
                                    <i data-lucide="chevron-down" class="size-4"></i>
                                </div>
                            </div>
                             <div class="relative">
                                <label class="block text-[11px] font-black text-pos-secondary uppercase tracking-widest mb-2 px-1">Nama Pelanggan</label>
                                <input type="text" wire:model.live="customerName" 
                                    class="w-full h-12 px-4 rounded-xl border-2 border-pos-border dark:border-zinc-800 focus:ring-4 focus:ring-primary-blue/10 focus:border-primary-blue outline-none font-bold text-sm text-pos-foreground bg-white dark:bg-pos-card-grey transition-all" 
                                    placeholder="Contoh: Budi">
                            </div>
                        </div>

                        @if($paymentMethod === 'cash')
                            <div class="relative animate-peek">
                                <label class="block text-[11px] font-black text-pos-secondary uppercase tracking-widest mb-2 px-1">Uang Diterima</label>
                                 <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-pos-foreground text-lg">Rp</span>
                                    <input type="number" wire:model.live="uangCustomer" 
                                        class="w-full h-14 pl-12 pr-4 text-xl font-black rounded-xl border-2 border-pos-border dark:border-zinc-800 focus:ring-4 focus:ring-primary-blue/10 focus:border-primary-blue outline-none text-pos-foreground bg-white dark:bg-pos-card-grey transition-all"
                                        placeholder="0">
                                </div>
                                
                                <div class="grid grid-cols-3 gap-2 mt-3">
                                    <button wire:click="$set('uangCustomer', {{ $total }})" class="py-2.5 text-[10px] font-black bg-pos-muted/50 dark:bg-pos-muted/20 border border-pos-border dark:border-zinc-800 rounded-lg hover:bg-primary-blue hover:text-white hover:border-primary-blue dark:hover:bg-primary-blue transition-all uppercase">Uang Pas</button>
                                    <button wire:click="$set('uangCustomer', {{ ceil($total / 50000) * 50000 }})" class="py-2.5 text-[10px] font-black bg-pos-muted/50 dark:bg-pos-muted/20 border border-pos-border dark:border-zinc-800 rounded-lg hover:bg-primary-blue hover:text-white hover:border-primary-blue dark:hover:bg-primary-blue transition-all">Rp {{ number_format(ceil($total / 50000) * 50000, 0, ',', '.') }}</button>
                                    <button wire:click="$set('uangCustomer', {{ ceil($total / 100000) * 100000 }})" class="py-2.5 text-[10px] font-black bg-pos-muted/50 dark:bg-pos-muted/20 border border-pos-border dark:border-zinc-800 rounded-lg hover:bg-primary-blue hover:text-white hover:border-primary-blue dark:hover:bg-primary-blue transition-all">Rp {{ number_format(ceil($total / 100000) * 100000, 0, ',', '.') }}</button>
                                </div>

                                <div class="flex justify-between items-center mt-4 bg-pos-card-grey/50 dark:bg-pos-muted/10 p-4 rounded-xl border border-pos-border dark:border-zinc-800">
                                    <span class="text-xs font-black text-pos-secondary uppercase tracking-widest">Kembalian</span>
                                    <span class="text-xl font-black {{ $kembalian > 0 ? 'text-pos-success' : 'text-pos-foreground/30' }}">
                                        Rp {{ number_format($kembalian, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        @elseif($paymentMethod === 'card')
                            <div class="grid grid-cols-2 gap-4 animate-peek">
                                <div>
                                    <label class="block text-[11px] font-black text-pos-secondary uppercase tracking-widest mb-2 px-1">4 Digit Terakhir</label>
                                    <input type="text" wire:model.live="cardLast4" maxlength="4" placeholder="1234"
                                        class="w-full h-12 px-4 rounded-xl border-2 border-pos-border dark:border-zinc-800 focus:ring-4 focus:ring-primary-blue/10 focus:border-primary-blue outline-none font-black text-center tracking-[0.2em] bg-white dark:bg-pos-card-grey transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-pos-secondary uppercase tracking-widest mb-2 px-1">Ref Transaksi</label>
                                    <input type="text" wire:model.live="paymentRef" placeholder="Opsional"
                                        class="w-full h-12 px-4 rounded-xl border-2 border-pos-border dark:border-zinc-800 focus:ring-4 focus:ring-primary-blue/10 focus:border-primary-blue outline-none font-bold text-pos-foreground bg-white dark:bg-pos-card-grey transition-all">
                                </div>
                            </div>
                        @elseif($paymentMethod === 'qris')
                            <div class="animate-peek">
                                <label class="block text-[11px] font-black text-pos-secondary uppercase tracking-widest mb-2 px-1">No. Referensi / Ref ID</label>
                                <input type="text" wire:model.live="paymentRef" placeholder="Masukkan ID transaksi"
                                    class="w-full h-12 px-4 rounded-xl border-2 border-pos-border dark:border-zinc-800 focus:ring-4 focus:ring-primary-blue/10 focus:border-primary-blue outline-none font-bold text-pos-foreground bg-white dark:bg-pos-card-grey transition-all">
                            </div>
                        @endif
                    </div>

                    <button wire:click="checkout" 
                        class="w-full h-16 bg-primary-blue text-white rounded-2xl font-black text-base uppercase tracking-widest hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/30 transition-all flex items-center justify-center gap-3 active:scale-95 disabled:opacity-50 disabled:grayscale disabled:pointer-events-none mt-auto"
                        wire:loading.attr="disabled"
                        :disabled="{{ (empty($customerName) || ($paymentMethod === 'cash' && (float)$uangCustomer < $total) || ($paymentMethod === 'card' && strlen($cardLast4) !== 4)) ? 'true' : 'false' }}"
                    >
                        <i data-lucide="check-circle" class="size-6" wire:loading.remove></i>
                        <i data-lucide="loader-2" class="size-6 animate-spin" wire:loading></i>
                        <span wire:loading.remove>Konfirmasi Pembayaran</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal: Sukses -->
     @if($showReceiptModal)
    <div class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-data x-init="if (window.lucide) lucide.createIcons()">
        <div class="absolute inset-0 bg-pos-foreground/70 backdrop-blur-md"></div>
        <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-sm text-center p-10 shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
            <div class="size-24 bg-pos-success/10 rounded-full flex items-center justify-center mx-auto mb-8">
                <i data-lucide="check" class="size-12 text-pos-success"></i>
            </div>
            <h3 class="text-2xl font-extrabold text-pos-foreground mb-2">Transaksi Berhasil!</h3>
            <p class="text-pos-secondary text-sm mb-10">Pesanan <span class="text-pos-foreground font-bold">#{{ $lastOrder?->no_order }}</span> telah diproses.</p>
            
            <div class="space-y-3">
                 <button wire:click="closeReceiptModal" class="w-full py-4 bg-primary-blue text-white rounded-full font-bold text-base hover:bg-primary-blue-hover transition-all active:scale-95">
                    Order Baru
                </button>
                <button wire:click="preparePrintReceipt" class="w-full py-4 bg-white dark:bg-pos-muted/20 border-2 border-pos-border dark:border-zinc-800 text-pos-foreground rounded-full font-bold text-base hover:bg-pos-muted transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i data-lucide="printer" class="size-5"></i>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal: Confirm Clear -->
     @if($showClearCartModal)
    <div class="fixed inset-0 z-[999] flex items-center justify-center p-4 text-center">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closeSuccessModal"></div>
        <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-xs p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
            <div class="size-20 bg-pos-error/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="alert-triangle" class="size-10 text-pos-error"></i>
            </div>
            <h3 class="text-xl font-bold text-pos-foreground mb-3">Hapus Keranjang?</h3>
            <p class="text-pos-secondary text-sm mb-8 leading-relaxed">Semua item yang telah dipilih akan dihapus secara permanen.</p>
            
            <div class="grid grid-cols-2 gap-3">
                <button wire:click="closeClearCartModal" class="py-3 bg-pos-muted text-pos-foreground rounded-2xl font-bold text-sm hover:bg-gray-200 transition-all">Batal</button>
                <button wire:click="clearCart" class="py-3 bg-pos-error text-white rounded-2xl font-bold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20">Hapus</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Receipt for Printing (System Hidden) -->
    @if($showPrintReceiptModal && $lastOrder)
        @include('livewire.pos.partials.receipt-print', ['order' => $lastOrder])
    @endif

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 20px; }
        
        @keyframes peek {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .animate-peek { animation: peek 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    </style>
</div>