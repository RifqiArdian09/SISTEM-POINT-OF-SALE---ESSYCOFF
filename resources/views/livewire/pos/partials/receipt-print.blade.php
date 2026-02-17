@php
    $width = '80mm'; 
    $fontSize = '12px';
    $padding = '10px';
@endphp

<div id="receipt-content" class="hidden print:block bg-white text-black absolute left-0 top-0"
    style="width: {{ $width }}; padding: {{ $padding }}; font-family: 'Courier New', monospace; font-size: {{ $fontSize }}; line-height: 1.3;">
    <div class="receipt-layout space-y-1">
        <!-- Header -->
        <div class="text-center mb-2">
            <h2 class="font-bold text-lg" style="margin-bottom: 4px;">EssyCoff</h2>
            <p class="text-[9px] leading-tight">Jl. Jati No.41, Padang Jati, Kota Bengkulu</p>
            <p class="text-[9px]">Telp: (0736) 1234567</p>
        </div>

        <hr class="my-1 border-dashed border-black" style="border-top: 1px dashed #000; margin: 4px 0;">

        <!-- Order Info -->
        <div class="space-y-0.5 mb-2 text-[9px]">
            <div class="flex justify-between">
                <span class="font-medium">No. order:</span>
                <span>{{ $order->no_order }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium">Kasir:</span>
                <span>{{ $order->user?->name ?? 'System' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium">Tanggal:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            @if($order->customer_name)
            <div class="flex justify-between">
                <span class="font-medium">Customer:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            @endif
        </div>

        <hr class="my-1 border-dashed border-black" style="border-top: 1px dashed #000; margin: 4px 0;">

        <!-- Items -->
        <div class="space-y-1 mb-2">
            @foreach($order->items as $item)
            <div class="flex justify-between text-[9px]">
                <div>
                    <span class="font-medium">{{ $item->product?->name ?? 'Produk dihapus' }}</span>
                    <div class="text-[8px] text-gray-600">
                        {{ $item->qty }} × Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </div>
                </div>
                <div class="text-right">
                    <div>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <hr class="my-1 border-dashed border-black" style="border-top: 1px dashed #000; margin: 4px 0;">

        <!-- Summary -->
        <div class="space-y-0.5 font-semibold text-[9px]">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold pt-1 mt-1 border-t border-black">
                <span>Total</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between pt-1 border-t border-black mt-1">
                <span>Metode</span>
                <span>{{ strtoupper($order->payment_method ?? 'CASH') }}</span>
            </div>
            @if($order->uang_dibayar !== null)
            <div class="flex justify-between">
                <span>Bayar</span>
                <span>Rp {{ number_format($order->uang_dibayar, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span>Kembali</span>
                <span>Rp {{ number_format($order->kembalian ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-3 text-[8px] text-gray-600">
            <p>Terima kasih atas kunjungan Anda</p>
            <p class="mt-0.5">~ EssyCoff ~</p>
        </div>
    </div>
</div>

<style>
    @media print {
        @page { margin: 0; }
        body * { visibility: hidden; }
        #receipt-content, #receipt-content * { visibility: visible; }
        #receipt-content {
            position: absolute !important;
            top: 0 !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: 58mm !important;
            padding: 6px !important;
            font-size: 10px !important;
        }
    }
</style>
