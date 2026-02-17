<div class="min-h-screen bg-pos-muted dark:bg-pos-muted pb-24" x-data="customerOrder()" x-init="init(); if (window.lucide) lucide.createIcons()">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Header -->
    <header class="bg-white dark:bg-pos-card-grey border-b border-pos-border dark:border-zinc-800 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <!-- Logo & Title -->
                <div class="flex items-center gap-4">
                    <div class="size-12 bg-white dark:bg-pos-muted rounded-2xl flex items-center justify-center shadow-lg border border-pos-border dark:border-zinc-800">
                        <img src="{{ asset('images/logo2.png') }}" alt="EssyCoff" class="w-8 h-8 rounded-xl">
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-pos-foreground">EssyCoff</h1>
                        <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">Menu Customer</p>
                    </div>
                </div>

                <!-- Table Info -->
                @php
                    $tableFromQuery = request()->query('table');
                @endphp
                @if($tableFromQuery)
                    <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-primary-blue/10 border border-primary-blue/20 rounded-2xl">
                        <i data-lucide="armchair" class="size-4 text-primary-blue"></i>
                        <span class="text-sm font-black text-primary-blue">Meja: {{ $tableFromQuery }}</span>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Search & Filter -->
        <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-6 mb-8 border border-pos-border dark:border-zinc-800 shadow-sm">
            <!-- Search -->
            <form method="GET" action="{{ route('customer') }}" class="mb-6">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari menu favorit Anda..."
                        class="w-full h-14 pl-12 pr-4 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 border-2 border-transparent focus:border-primary-blue outline-none text-pos-foreground placeholder:text-pos-secondary font-medium transition-all">
                    <input type="hidden" name="category" value="{{ $category ?? 'all' }}">
                </div>
            </form>

            <!-- Category Filter -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('customer', ['search' => $search ?? '', 'category' => 'all']) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all {{ ($category ?? 'all') === 'all' ? 'bg-primary-blue text-white shadow-lg shadow-primary-blue/25' : 'bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:text-pos-foreground border border-pos-border dark:border-zinc-800' }}">
                    <i data-lucide="layout-grid" class="size-4"></i>
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('customer', ['search' => $search ?? '', 'category' => strtolower($cat->name)]) }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all {{ ($category ?? 'all') === strtolower($cat->name) ? 'bg-primary-blue text-white shadow-lg shadow-primary-blue/25' : 'bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:text-pos-foreground border border-pos-border dark:border-zinc-800' }}">
                        <i data-lucide="coffee" class="size-4"></i>
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="group bg-white dark:bg-pos-card-grey rounded-[24px] overflow-hidden border border-pos-border dark:border-zinc-800 hover:border-primary-blue dark:hover:border-primary-blue hover:shadow-xl hover:shadow-primary-blue/5 transition-all {{ $product->stock <= 0 ? 'opacity-60' : '' }}">
                    <!-- Product Image -->
                    <div class="relative aspect-square overflow-hidden bg-pos-muted dark:bg-pos-muted/20">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="image" class="size-16 text-pos-secondary/30"></i>
                            </div>
                        @endif

                        <!-- Stock Badge -->
                        @if($product->stock <= 0)
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                <span class="px-4 py-2 bg-pos-error text-white rounded-full text-sm font-black">Habis</span>
                            </div>
                        @else
                            <div class="absolute top-3 right-3 px-3 py-1.5 bg-pos-success/90 backdrop-blur-sm text-white rounded-xl text-xs font-black">
                                Stok: {{ $product->stock }}
                            </div>
                        @endif

                        <!-- Favorite Badge -->
                        @if($product->favorite_data['total_ordered'] > 0)
                            <div class="absolute top-3 left-3 px-3 py-1.5 bg-pos-error/90 backdrop-blur-sm text-white rounded-xl text-xs font-black flex items-center gap-1">
                                <i data-lucide="heart" class="size-3 fill-current"></i>
                                {{ $product->favorite_data['total_ordered'] }}x
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="mb-3">
                            <h3 class="font-black text-pos-foreground text-lg mb-2 line-clamp-2">{{ $product->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-1 bg-primary-blue/10 text-primary-blue rounded-lg text-xs font-bold">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-xl font-black text-pos-foreground">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            @if($product->stock > 0)
                                <button @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})"
                                    class="flex items-center gap-2 px-4 py-2.5 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-primary-blue/20">
                                    <i data-lucide="plus" class="size-4"></i>
                                    Tambah
                                </button>
                            @else
                                <span class="text-pos-secondary text-sm font-bold">Tidak Tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16">
                    <div class="size-20 bg-pos-muted dark:bg-pos-muted/20 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="coffee" class="size-10 text-pos-secondary/30"></i>
                    </div>
                    <h3 class="text-xl font-black text-pos-foreground mb-2">Belum Ada Produk</h3>
                    <p class="text-pos-secondary">Produk akan segera ditambahkan</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Floating Cart Button -->
    <button @click="toggleCart()" 
        class="fixed bottom-6 right-6 size-16 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-full shadow-2xl shadow-primary-blue/30 flex items-center justify-center z-40 transition-all hover:scale-110">
        <i data-lucide="shopping-cart" class="size-6"></i>
        <span x-show="cartCount > 0" x-text="cartCount" 
            class="absolute -top-2 -right-2 size-6 bg-pos-error text-white text-xs font-black rounded-full flex items-center justify-center"></span>
    </button>

    <!-- Cart Sidebar -->
    <div x-show="showCart" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white dark:bg-pos-card-grey shadow-2xl z-50 flex flex-col"
        style="display: none;">
        
        <!-- Cart Header -->
        <div class="bg-primary-blue text-white p-6 flex items-center justify-between">
            <h3 class="text-xl font-black">Keranjang Belanja</h3>
            <button @click="toggleCart()" class="size-10 hover:bg-white/10 rounded-xl flex items-center justify-center transition-colors">
                <i data-lucide="x" class="size-6"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6 custom-scroll">
            <template x-if="cart.length === 0">
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="size-20 bg-pos-muted dark:bg-pos-muted/20 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="shopping-cart" class="size-10 text-pos-secondary/30"></i>
                    </div>
                    <p class="text-lg font-black text-pos-foreground mb-2">Keranjang Kosong</p>
                    <p class="text-sm text-pos-secondary">Tambahkan produk untuk mulai berbelanja</p>
                </div>
            </template>

            <div class="space-y-4">
                <template x-for="item in cart" :key="item.id">
                    <div class="bg-pos-muted dark:bg-pos-muted/20 rounded-2xl p-4 border border-pos-border dark:border-zinc-800">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h4 class="font-black text-pos-foreground" x-text="item.name"></h4>
                                <p class="text-sm text-pos-secondary">
                                    Rp <span x-text="Number(item.price).toLocaleString('id-ID')"></span> × <span x-text="item.quantity"></span>
                                </p>
                            </div>
                            <button @click="removeFromCart(item.id)" class="text-pos-error hover:bg-pos-error/10 p-2 rounded-lg transition-colors">
                                <i data-lucide="trash-2" class="size-4"></i>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button @click="decreaseQuantity(item.id)" class="size-8 bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 rounded-lg font-bold hover:bg-pos-border dark:hover:bg-pos-muted/40 transition-colors">-</button>
                                <span class="w-12 text-center font-black text-pos-foreground" x-text="item.quantity"></span>
                                <button @click="increaseQuantity(item.id)" class="size-8 bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 rounded-lg font-bold hover:bg-pos-border dark:hover:bg-pos-muted/40 transition-colors">+</button>
                            </div>
                            <div class="text-lg font-black text-pos-foreground">
                                Rp <span x-text="(Number(item.price) * Number(item.quantity)).toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Cart Footer -->
        <div class="border-t border-pos-border dark:border-zinc-800 p-6 bg-pos-muted/30 dark:bg-pos-muted/10">
            <!-- Customer Name -->
            <div class="mb-4">
                <label class="block text-sm font-black text-pos-secondary uppercase tracking-widest mb-2">Nama Pemesan</label>
                <input type="text" x-model="customerName" placeholder="Masukkan nama Anda"
                    class="w-full h-12 px-4 rounded-xl bg-white dark:bg-pos-card-grey border-2 border-pos-border dark:border-zinc-800 focus:border-primary-blue outline-none text-pos-foreground font-medium transition-all">
            </div>

            <!-- Total -->
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-black text-pos-secondary uppercase tracking-widest">Total</span>
                <span class="text-2xl font-black text-pos-foreground">Rp <span x-text="cartTotal.toLocaleString('id-ID')"></span></span>
            </div>

            <!-- Actions -->
            <div class="space-y-2">
                <button @click="checkout()" :disabled="cart.length === 0 || !customerName.trim()"
                    class="w-full py-4 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-2xl font-black transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-primary-blue/20">
                    Checkout
                </button>
                <button @click="clearCart()" :disabled="cart.length === 0"
                    class="w-full py-3 bg-pos-error/10 hover:bg-pos-error/20 text-pos-error rounded-2xl font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="trash-2" class="size-4 inline mr-2"></i>Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div x-show="showSuccessModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-md flex items-center justify-center z-[999] p-4"
        style="display: none;">
        <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-8 max-w-md w-full text-center shadow-2xl border border-pos-border dark:border-zinc-800 animate-peek">
            <div class="size-20 bg-pos-success/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="check-circle" class="size-10 text-pos-success"></i>
            </div>
            <h3 class="text-2xl font-black text-pos-foreground mb-3">Pesanan Berhasil!</h3>
            <p class="text-pos-secondary mb-6">Pesanan Anda telah dikirim ke kasir</p>
            
            <div class="bg-pos-muted dark:bg-pos-muted/20 rounded-2xl p-4 mb-6 text-left">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-pos-secondary">Nama:</span>
                    <span class="font-black text-pos-foreground" x-text="customerName"></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-pos-secondary">Total:</span>
                    <span class="font-black text-lg text-primary-blue">Rp <span x-text="lastOrderTotal.toLocaleString('id-ID')"></span></span>
                </div>
            </div>

            <div class="bg-pos-warning/10 border border-pos-warning/20 rounded-2xl p-4 mb-6 text-left">
                <div class="flex items-start gap-3">
                    <i data-lucide="info" class="size-5 text-pos-warning shrink-0 mt-0.5"></i>
                    <div class="text-sm text-pos-secondary">
                        <p class="font-bold text-pos-foreground mb-1">Silakan ke Kasir</p>
                        <p>Lakukan pembayaran di kasir untuk memproses pesanan Anda.</p>
                    </div>
                </div>
            </div>

            <button @click="closeSuccessModal()" 
                class="w-full py-4 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-2xl font-black transition-all shadow-lg shadow-primary-blue/20">
                Selesai
            </button>
        </div>
    </div>

    <script>
        function customerOrder() {
            return {
                cart: [],
                showCart: false,
                showSuccessModal: false,
                customerName: '',
                lastOrderTotal: 0,
                
                get cartCount() {
                    return this.cart.reduce((total, item) => total + item.quantity, 0);
                },
                
                get cartTotal() {
                    return this.cart.reduce((total, item) => total + (Number(item.price) * Number(item.quantity)), 0);
                },
                
                init() {
                    this.$watch('cart', value => {
                        console.log('Cart changed', value);
                    });
                    
                    // Initialize Lucide icons after Alpine loads
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },
                
                addToCart(id, name, price, stock) {
                    const existingItem = this.cart.find(item => item.id === id);
                    const currentQty = existingItem ? existingItem.quantity : 0;
                    
                    if (currentQty >= stock) {
                        alert(`Stok ${name} tidak mencukupi. Tersisa ${stock} item`);
                        return;
                    }
                    
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.cart.push({ id, name, price: Number(price), quantity: 1, stock });
                    }
                    
                    console.log('Cart updated:', this.cart);
                    console.log('Cart total:', this.cartTotal);
                    
                    // Auto-open cart on desktop
                    if (window.innerWidth >= 768) {
                        this.showCart = true;
                    }
                    
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },
                
                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },
                
                increaseQuantity(id) {
                    const item = this.cart.find(i => i.id === id);
                    if (item && item.quantity < item.stock) {
                        item.quantity++;
                    }
                },
                
                decreaseQuantity(id) {
                    const item = this.cart.find(i => i.id === id);
                    if (item) {
                        if (item.quantity > 1) {
                            item.quantity--;
                        } else {
                            this.removeFromCart(id);
                        }
                    }
                },
                
                toggleCart() {
                    this.showCart = !this.showCart;
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },
                
                clearCart() {
                    if (confirm('Yakin ingin mengosongkan keranjang?')) {
                        this.cart = [];
                    }
                },
                
                async checkout() {
                    if (!this.customerName.trim()) {
                        alert('Harap masukkan nama pemesan');
                        return;
                    }
                    
                    if (this.cart.length === 0) {
                        alert('Keranjang masih kosong');
                        return;
                    }
                    
                    try {
                        const tableCode = new URLSearchParams(window.location.search).get('table');
                        
                        const response = await fetch('{{ route("customer.order") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: JSON.stringify({
                                customer_name: this.customerName,
                                table: tableCode,
                                total: this.cartTotal,
                                items: this.cart.map(item => ({
                                    id: item.id,
                                    quantity: item.quantity
                                }))
                            })
                        });

                        
                        const data = await response.json();
                        
                        if (data.success) {
                            this.lastOrderTotal = this.cartTotal;
                            this.showSuccessModal = true;
                            this.showCart = false;
                            this.cart = [];
                            this.$nextTick(() => {
                                if (window.lucide) lucide.createIcons();
                            });
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                        }
                    } catch (error) {
                        console.error('Checkout error:', error);
                        alert('Terjadi kesalahan saat memproses pesanan');
                    }
                },
                
                closeSuccessModal() {
                    this.showSuccessModal = false;
                    this.customerName = '';
                }
            }
        }
    </script>
</div>