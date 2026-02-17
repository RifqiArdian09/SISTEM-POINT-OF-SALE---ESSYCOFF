<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('pos.history') }}" class="text-xs font-black text-pos-secondary hover:text-primary-blue uppercase tracking-widest transition-colors flex items-center gap-1" wire:navigate>
                    <i data-lucide="arrow-left" class="size-3"></i>
                    Kembali ke Riwayat
                </a>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight flex items-center gap-4">
                {{ $order->no_order }}
                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                    {{ $order->status === 'paid' ? 'bg-pos-success/10 text-pos-success border border-pos-success/20' : 'bg-pos-warning/10 text-pos-warning border border-pos-warning/20' }}">
                    {{ $order->status === 'paid' ? 'Selesai' : 'Menunggu Pembayaran' }}
                </span>
            </h1>
            <p class="text-pos-secondary font-medium mt-1">Dibuat oleh <span class="text-pos-foreground font-bold">{{ $order->user?->name ?? 'System' }}</span> pada {{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
        </div>

        <div class="flex items-center gap-3">
            @if($order->status === 'paid')
                <button wire:click="printReceipt" class="flex items-center gap-2 px-6 py-4 rounded-2xl bg-white dark:bg-zinc-800 border border-pos-border dark:border-zinc-700 text-pos-foreground font-bold text-sm hover:bg-pos-card-grey dark:hover:bg-zinc-700 transition-all active:scale-95 shadow-sm">
                    <i data-lucide="printer" class="size-5 text-pos-secondary"></i>
                    <span>Cetak Struk</span>
                </button>
            @else
                <button wire:click="openPaymentModal" class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-primary-blue text-white font-bold text-sm hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95">
                    <i data-lucide="credit-card" class="size-5"></i>
                    <span>Tuntaskan Pembayaran</span>
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-pos-success/10 border border-pos-success/20 p-4 rounded-2xl flex items-center gap-3 text-pos-success font-bold text-sm">
            <i data-lucide="check-circle" class="size-5"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
         <!-- Left: Summary Info -->
        <div class="space-y-8">
            <!-- Payment Info -->
            <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm">
                <h3 class="text-lg font-black text-pos-foreground tracking-tight mb-6">Ringkasan Pembayaran</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-[10px] font-black text-pos-secondary uppercase tracking-widest">Total Tagihan</span>
                        <span class="text-2xl font-black text-pos-foreground">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($order->status === 'paid')
                        <div class="h-px bg-pos-border my-2"></div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-pos-secondary">Metode</span>
                            <span class="font-black text-pos-foreground uppercase tracking-widest">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-pos-secondary">Uang Tunai</span>
                            <span class="font-black text-pos-foreground">Rp {{ number_format($order->uang_dibayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-pos-secondary">Kembalian</span>
                            <span class="font-black text-pos-success">Rp {{ number_format($order->kembalian, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

             <!-- Table Info -->
            @if($order->table)
                <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5">
                        <i data-lucide="armchair" class="size-32"></i>
                    </div>
                     <h3 class="text-lg font-black text-pos-foreground tracking-tight mb-6">Informasi Meja</h3>
                    <div class="flex items-center gap-4">
                        <div class="size-16 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-pos-foreground">
                            <span class="text-2xl font-black">{{ $order->table->code }}</span>
                        </div>
                        <div>
                            <p class="font-black text-pos-foreground">{{ $order->table->name }}</p>
                            <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">Lokasi Meja</p>
                        </div>
                    </div>

                     @if($order->table->status === 'unavailable')
                        <button wire:click="markTableAvailable" class="w-full mt-6 py-4 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-black text-sm uppercase tracking-widest hover:bg-pos-border dark:hover:bg-pos-muted transition-all flex items-center justify-center gap-2">
                            <i data-lucide="check" class="size-4"></i>
                            <span>Tandai Tersedia</span>
                        </button>
                    @endif
                </div>
            @endif

             <!-- Log Info -->
            <div class="bg-pos-card-grey/50 dark:bg-pos-muted/10 p-6 rounded-[32px] border border-pos-border dark:border-zinc-800 space-y-4">
                <div class="flex gap-4">
                    <div class="size-10 rounded-xl bg-white dark:bg-pos-card-grey flex items-center justify-center text-pos-secondary shrink-0 shadow-sm">
                        <i data-lucide="user" class="size-5"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest mb-1">Nama Customer</p>
                        <p class="text-sm font-black text-pos-foreground capitalize">{{ $order->customer_name ?? 'Guest' }}</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="size-10 rounded-xl bg-white dark:bg-pos-card-grey flex items-center justify-center text-pos-secondary shrink-0 shadow-sm">
                        <i data-lucide="clock" class="size-5"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest mb-1">Durasi Pesanan</p>
                        <p class="text-sm font-black text-pos-foreground">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

         <!-- Right: Order Items -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-pos-border dark:border-zinc-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-pos-foreground tracking-tight">Daftar Item</h3>
                        <p class="text-xs text-pos-secondary font-bold uppercase tracking-widest mt-1">Total {{ $order->items->count() }} item dipesan</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-pos-card-grey/30 dark:bg-pos-muted/10">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Produk</th>
                                <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-center">Qty</th>
                                <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Harga</th>
                                <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pos-border dark:divide-zinc-800">
                            @foreach($order->items as $item)
                                <tr class="group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="size-14 rounded-2xl overflow-hidden bg-pos-muted dark:bg-pos-muted/20 border border-pos-border dark:border-zinc-800 shrink-0">
                                                @if($item->product?->image_url)
                                                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-pos-secondary/20">
                                                        <i data-lucide="image" class="size-6"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-black text-pos-foreground group-hover:text-primary-blue transition-colors text-sm capitalize">{{ $item->product?->name ?? 'Produk dihapus' }}</p>
                                                <p class="text-[10px] font-black text-primary-blue/60 uppercase tracking-widest">{{ $item->product?->category?->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="inline-flex size-10 items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-black text-sm">
                                            {{ $item->qty }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="text-sm font-bold text-pos-secondary">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="text-base font-black text-pos-foreground">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-pos-muted/20 dark:bg-pos-muted/5">
                                <td colspan="3" class="px-8 py-6 text-right font-black text-pos-secondary uppercase tracking-widest text-xs">Total Pembayaran</td>
                                <td class="px-8 py-6 text-right font-black text-xl text-primary-blue">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            @if($order->status === 'pending_payment')
                <div class="p-8 bg-pos-warning/10 rounded-[40px] border border-pos-warning/20 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4 text-pos-warning">
                        <div class="size-12 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                            <i data-lucide="alert-circle" class="size-6"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-sm uppercase tracking-widest">Menunggu Pelunasan</h4>
                            <p class="text-[11px] font-medium text-pos-warning/80">Pesanan ini belum dibayar. Mohon tanyakan customer sebelum menutup kasir.</p>
                        </div>
                    </div>
                    <button wire:click="openPaymentModal" class="px-8 py-4 rounded-2xl bg-pos-warning text-white font-black text-xs uppercase tracking-widest hover:bg-pos-warning/80 shadow-lg shadow-pos-warning/10 transition-all">
                        Proses Pembayaran
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Pembayaran (Same as index but matching current design) -->
    @if($showPaymentModal)
         <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closePaymentModal"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-md p-10 shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-pos-foreground tracking-tight">Selesaikan Pembayaran</h3>
                        <p class="text-pos-secondary text-sm font-medium mt-1">Total Tagihan: <span class="text-primary-blue font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</span></p>
                    </div>
                    <button wire:click="closePaymentModal" class="size-10 rounded-full bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-pos-secondary hover:text-pos-error transition-colors">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <div class="space-y-8">
                    <!-- Method Selector -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach(['cash' => 'Coins', 'qris' => 'Qr-code', 'card' => 'Credit-card'] as $key => $icon)
                                <button wire:click="$set('paymentMethod', '{{ $key }}')" 
                                    class="flex flex-col items-center gap-2 p-5 rounded-3xl border-2 transition-all {{ $paymentMethod === $key ? 'border-primary-blue bg-primary-blue/5 text-primary-blue' : 'border-pos-border dark:border-zinc-700 bg-pos-muted/20 dark:bg-pos-muted/10 text-pos-secondary hover:border-pos-secondary/30' }}">
                                    <i data-lucide="{{ $icon }}" class="size-6"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest">{{ $key }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    @if($paymentMethod === 'cash')
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Uang yang Dibayar</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-pos-foreground text-lg">Rp</span>
                                <input type="number" wire:model.live="uangDibayar" class="w-full h-20 pl-16 pr-6 rounded-3xl bg-pos-muted dark:bg-pos-muted/20 border-none font-black text-2xl text-pos-foreground outline-none focus:ring-4 focus:ring-primary-blue/10">
                            </div>
                            @error('uangDibayar') <span class="text-xs font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                        </div>
                    @elseif($paymentMethod === 'card')
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">4 Digit Terakhir Kartu</label>
                            <input type="text" wire:model.live="cardLast4" maxlength="4" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 border-none font-black text-lg text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20" placeholder="0000">
                            @error('cardLast4') <span class="text-xs font-bold text-pos-error px-1">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    @php
                        $total = (float)($order->total ?? 0);
                        $dibayar = (float)($uangDibayar ?: 0);
                        $kembali = max(0, $dibayar - $total);
                    @endphp

                    @if($paymentMethod === 'cash' && $dibayar >= $total)
                        <div class="p-6 bg-pos-success/5 rounded-3xl border border-pos-success/20 flex items-center justify-between">
                            <span class="text-sm font-black text-pos-success uppercase tracking-widest">Uang Kembalian</span>
                            <span class="text-2xl font-black text-pos-success">Rp {{ number_format($kembali, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <button wire:click="processPayment" class="w-full h-16 rounded-3xl bg-primary-blue text-white font-black text-sm uppercase tracking-widest hover:bg-primary-blue-hover shadow-2xl shadow-primary-blue/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="shield-check" class="size-5"></i>
                        <span>Konfirmasi Pembayaran</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Receipt Print Layout (Invisible in screen, visible in print) -->
    @include('livewire.pos.partials.receipt-print', ['order' => $order])

    <style>
        .animate-peek { animation: peek 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes peek {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('printReceipt', () => {
                setTimeout(() => { window.print(); }, 300);
            });
        });
    </script>
</div>