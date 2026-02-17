<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="history" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Aktivitas Point of Sale</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Riwayat Transaksi</h1>
            <p class="text-pos-secondary font-medium mt-1">Cetak ulang struk, selesaikan pembayaran tertunda, atau audit order.</p>
        </div>
        
        <div class="flex items-center gap-3 bg-white dark:bg-pos-card-grey px-5 py-3 rounded-2xl border border-pos-border dark:border-zinc-800 shadow-sm">
            <div class="size-10 bg-pos-success/10 rounded-xl flex items-center justify-center text-pos-success">
                <i data-lucide="check-circle-2" class="size-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-pos-secondary uppercase tracking-tight leading-none mb-1">Status Selesai</p>
                <p class="text-sm font-black text-pos-foreground leading-none">Sudah Dibayar</p>
            </div>
        </div>
    </div>

     <!-- Interactive Filters -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Search -->
            <div class="lg:col-span-2 space-y-2">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Cari Order</label>
                 <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary/40"></i>
                    <input type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="ID Pesanan atau nama pelanggan..." 
                        class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-sm">
                </div>
            </div>

            <!-- Month -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Periode</label>
                 <div class="relative">
                    <i data-lucide="calendar" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary/40 pointer-events-none"></i>
                    <select wire:model.live="selectedMonth" class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none font-bold text-sm appearance-none cursor-pointer text-pos-foreground">
                        <option value="">Semua Waktu</option>
                        @foreach($availableMonths as $month)
                            <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Posisi / Meja</label>
                 <div class="relative">
                    <i data-lucide="table-2" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary/40 pointer-events-none"></i>
                    <select wire:model.live="selectedTableId" class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none font-bold text-sm appearance-none cursor-pointer text-pos-foreground">
                        <option value="">Semua Lokasi</option>
                        @foreach(($tables ?? collect()) as $t)
                            <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->code }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

         <div class="mt-8 flex items-center justify-between border-t border-pos-border dark:border-zinc-800 pt-6">
            <div class="flex items-center gap-2">
                <button wire:click="$set('status','all')" class="px-5 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all {{ $status === 'all' ? 'bg-pos-foreground dark:bg-zinc-800 text-white shadow-lg' : 'bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:text-pos-foreground' }}">Semua Status</button>
                <button wire:click="$set('status','pending_payment')" class="px-5 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all {{ $status === 'pending_payment' ? 'bg-pos-warning text-white shadow-lg shadow-pos-warning/20' : 'bg-pos-warning/5 text-pos-warning hover:bg-pos-warning/10' }}">Tertunda</button>
                <button wire:click="$set('status','paid')" class="px-5 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all {{ $status === 'paid' ? 'bg-pos-success text-white shadow-lg shadow-pos-success/20' : 'bg-pos-success/5 text-pos-success hover:bg-pos-success/10' }}">Selesai</button>
            </div>
            
            <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest">Ditemukan <span class="text-primary-blue">{{ $orders->total() }}</span> Katalog</p>
        </div>
    </div>

    <!-- History List -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden" wire:poll.visible.5s>
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-pos-card-grey/50 dark:bg-pos-muted/10">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest w-16 text-center">No</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Order ID</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Detail Pesanan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Meja</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Total</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-center">Metode</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pos-border dark:divide-zinc-800">
                    @forelse ($orders as $index => $order)
                        <tr class="hover:bg-pos-muted/20 dark:hover:bg-pos-muted/5 transition-colors group">
                            <td class="px-8 py-5 text-center">
                                <span class="text-xs font-bold text-pos-secondary">{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-pos-foreground group-hover:text-primary-blue transition-colors uppercase">#{{ $order->no_order }}</span>
                                    <span class="text-[10px] font-black text-pos-secondary mt-1 bg-pos-muted dark:bg-pos-muted/20 px-2 py-0.5 rounded-md w-fit uppercase">{{ $order->created_at->format('H:i:s') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-pos-secondary border border-pos-border dark:border-zinc-800">
                                        <i data-lucide="user" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-pos-foreground capitalize">{{ $order->customer_name ?? 'Umum / Guest' }}</p>
                                        <p class="text-[10px] font-bold text-pos-secondary uppercase tracking-widest mt-0.5">{{ $order->user?->name ?? 'System' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @if($order->table)
                                    <span class="px-3 py-1.5 rounded-xl bg-primary-blue/5 text-primary-blue text-[10px] font-black border border-primary-blue/10 uppercase tracking-widest">
                                        {{ $order->table->code }}
                                    </span>
                                @else
                                    <span class="text-pos-secondary/30 text-xs font-bold italic">Bawa Pulang</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right font-black text-pos-foreground">
                                Rp {{ number_format((float)$order->total, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($order->status === 'paid')
                                    <span class="px-3 py-1.5 rounded-xl bg-pos-success/10 text-pos-success text-[10px] font-black uppercase tracking-widest border border-pos-success/20">
                                        {{ $order->payment_method ?? 'CASH' }}
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 rounded-xl bg-pos-warning/10 text-pos-warning text-[10px] font-black uppercase tracking-widest border border-pos-warning/20">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    @if($order->status === 'pending_payment')
                                        <button wire:click="confirmPayment({{ $order->id }})" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-pos-success text-white font-black text-[10px] uppercase hover:bg-pos-success/90 transition-all shadow-lg shadow-pos-success/20">
                                            <i data-lucide="credit-card" class="size-4"></i>
                                            <span>Bayar</span>
                                        </button>
                                    @else
                                        <a href="{{ route('pos.detail', $order) }}" class="size-11 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:bg-primary-blue hover:text-white transition-all shadow-sm" wire:navigate>
                                            <i data-lucide="receipt" class="size-5"></i>
                                        </a>
                                    @endif
                                    
                                    <button wire:click="confirmDelete({{ $order->id }})" class="size-11 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:bg-pos-error hover:text-white transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="size-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-8 py-24 text-center text-pos-secondary/30">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-24 bg-pos-muted dark:bg-pos-muted/20 rounded-full flex items-center justify-center">
                                        <i data-lucide="ghost" class="size-12"></i>
                                    </div>
                                    <p class="text-lg font-black text-pos-foreground/40">Data Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
            <div class="px-8 py-6 bg-pos-card-grey/30 dark:bg-pos-muted/10 border-t border-pos-border dark:border-zinc-800 flex items-center justify-between">
                <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">Halaman <span class="text-primary-blue">{{ $orders->currentPage() }}</span> / {{ $orders->lastPage() }}</p>
                {{ $orders->links('components.pagination.premium') }}
            </div>
        @endif
    </div>

    <!-- Payment Confirmation Modal -->
    @if($showPaymentModal && $selectedOrder)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closeModal"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-md p-8 shadow-2xl animate-peek flex flex-col gap-8 overflow-hidden border border-pos-border dark:border-zinc-800">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i data-lucide="credit-card" class="size-32"></i>
                </div>
                
                <div>
                    <h3 class="text-2xl font-black text-pos-foreground tracking-tight">Selesaikan Pembayaran</h3>
                    <p class="text-pos-secondary text-sm font-medium">Order ID <span class="text-primary-blue font-bold">#{{ $selectedOrder->no_order }}</span> oleh {{ $selectedOrder->customer_name ?? 'Umum' }}</p>
                </div>

                <div class="bg-pos-muted/50 dark:bg-pos-muted/10 rounded-[32px] p-8 border border-pos-border dark:border-zinc-800 space-y-2">
                    <p class="text-xs font-black text-pos-secondary uppercase tracking-widest text-center mb-2">Total Tagihan</p>
                    <h2 class="text-4xl font-black text-pos-foreground text-center">Rp {{ number_format((float)$selectedOrder->total, 0, ',', '.') }}</h2>
                </div>

                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Pilih Metode Pembayaran</label>
                         <div class="grid grid-cols-3 gap-3">
                            <button wire:click="$set('paymentMethod','cash')" class="h-16 rounded-2xl border-2 flex flex-col items-center justify-center gap-1 transition-all {{ $paymentMethod === 'cash' ? 'bg-primary-blue/5 border-primary-blue text-primary-blue' : 'bg-white dark:bg-zinc-800 border-pos-border dark:border-zinc-700 text-pos-secondary hover:border-pos-secondary' }}">
                                <i data-lucide="banknote" class="size-5"></i>
                                <span class="text-[10px] font-black uppercase">Tunai</span>
                            </button>
                            <button wire:click="$set('paymentMethod','qris')" class="h-16 rounded-2xl border-2 flex flex-col items-center justify-center gap-1 transition-all {{ $paymentMethod === 'qris' ? 'bg-primary-blue/5 border-primary-blue text-primary-blue' : 'bg-white dark:bg-zinc-800 border-pos-border dark:border-zinc-700 text-pos-secondary hover:border-pos-secondary' }}">
                                <i data-lucide="qr-code" class="size-5"></i>
                                <span class="text-[10px] font-black uppercase">QRIS</span>
                            </button>
                            <button wire:click="$set('paymentMethod','card')" class="h-16 rounded-2xl border-2 flex flex-col items-center justify-center gap-1 transition-all {{ $paymentMethod === 'card' ? 'bg-primary-blue/5 border-primary-blue text-primary-blue' : 'bg-white dark:bg-zinc-800 border-pos-border dark:border-zinc-700 text-pos-secondary hover:border-pos-secondary' }}">
                                <i data-lucide="credit-card" class="size-5"></i>
                                <span class="text-[10px] font-black uppercase">Kartu</span>
                            </button>
                        </div>
                    </div>

                    @if($paymentMethod === 'cash')
                         <div class="space-y-3">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Uang Diterima (Rp)</label>
                            <input type="number" wire:model.live="uangDibayar" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 text-xl font-black text-pos-foreground outline-none">
                            
                            @php
                                $total = (float)$selectedOrder->total;
                                $diff = (float)($uangDibayar ?? 0) - $total;
                            @endphp
                            
                            @if($diff >= 0)
                                <div class="p-4 rounded-2xl bg-pos-success/10 border border-pos-success/20 flex justify-between items-center animate-peek">
                                    <span class="text-xs font-bold text-pos-success uppercase tracking-widest">Kembalian</span>
                                    <span class="text-lg font-black text-pos-success">Rp {{ number_format($diff, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                    @else
                         <div class="space-y-3 animate-peek">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Nomor Referensi (Opsional)</label>
                            <input type="text" wire:model.live="paymentRef" placeholder="Misal: ID Ref Bank / DANA / QRIS" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 font-bold text-sm outline-none text-pos-foreground">
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="closeModal" class="h-14 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-black text-sm hover:bg-pos-border dark:hover:bg-pos-muted transition-all">Batalkan</button>
                    <button wire:click="processPayment" 
                        @if($paymentMethod === 'cash' && ((float)($uangDibayar ?? 0) < (float)$selectedOrder->total)) disabled @endif
                        class="h-14 bg-primary-blue text-white rounded-2xl font-black text-sm hover:bg-primary-blue-hover transition-all shadow-xl shadow-primary-blue/20 disabled:opacity-50 disabled:grayscale">
                        Finalisasi Pemesanan
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Receipt Modal -->
    @if($showReceiptModal && $selectedOrder)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closeReceiptModal"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-sm text-center p-10 shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="size-24 bg-pos-success/10 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i data-lucide="check" class="size-12 text-pos-success"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-pos-foreground mb-2">Transaksi Berhasil!</h3>
                <p class="text-pos-secondary text-sm mb-10">Pesanan <span class="text-pos-foreground font-bold">#{{ $selectedOrder->no_order }}</span> telah lunas.</p>
                
                <div class="space-y-3">
                    <button @click="window.print()" class="w-full py-4 bg-primary-blue text-white rounded-2xl font-bold text-base hover:bg-primary-blue-hover transition-all shadow-xl shadow-primary-blue/30 active:scale-95 flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="size-5"></i>
                        Cetak Struk
                    </button>
                    <button wire:click="closeReceiptModal" class="w-full py-4 bg-pos-muted dark:bg-pos-muted/20 border-2 border-transparent text-pos-foreground rounded-2xl font-bold text-base hover:bg-pos-border dark:hover:bg-pos-muted transition-all active:scale-95">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal && $orderToDelete)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closeDeleteModal"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-sm p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="size-20 bg-pos-error/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="trash-2" class="size-10 text-pos-error"></i>
                </div>
                <h3 class="text-2xl font-black text-pos-foreground mb-3 tracking-tight">Hapus Transaksi</h3>
                <p class="text-pos-secondary text-sm font-medium mb-8 leading-relaxed">Anda yakin ingin menghapus <span class="text-pos-error font-bold">#{{ $orderToDelete->no_order }}</span>? Stok produk akan dikembalikan otomatis.</p>
                
                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="closeDeleteModal" class="py-4 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-extrabold text-sm hover:bg-pos-border dark:hover:bg-pos-muted transition-all">Batal</button>
                    <button wire:click="deleteOrder" class="py-4 bg-pos-error text-white rounded-2xl font-extrabold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20">Konfirmasi Hapus</button>
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
        
        @media print {
            body * { visibility: hidden; }
            #printable-receipt, #printable-receipt * { visibility: visible; }
            #printable-receipt { position: fixed; left: 0; top: 0; width: 100%; height: 100%; z-index: 9999; background: white; padding: 0; margin: 0; }
            @page { size: 58mm auto; margin: 0; }
        }
    </style>
    
    <!-- Printable Area (Hidden on Screen) -->
    @if($selectedOrder && ($showReceiptModal || $showPaymentModal))
        <div id="printable-receipt" class="hidden print:block">
            @include('livewire.pos.partials.receipt-print', ['order' => $selectedOrder])
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('printReceipt', () => {
                setTimeout(() => {
                    window.print();
                }, 500);
            });
        });
    </script>
</div>