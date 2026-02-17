<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="file-text" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Analisis Bisnis</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Laporan Penjualan</h1>
            <p class="text-pos-secondary font-medium mt-1">Pantau performa outlet dan ekspor data untuk kebutuhan akuntansi.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <button wire:click="exportExcel" class="flex items-center gap-2 px-5 py-3 rounded-xl bg-pos-success text-white font-bold text-sm hover:bg-pos-success/90 transition-all shadow-lg shadow-pos-success/20 active:scale-95">
                <i data-lucide="file-spreadsheet" class="size-5"></i>
                <span>Excel</span>
            </button>
            <button wire:click="exportPDF" class="flex items-center gap-2 px-5 py-3 rounded-xl bg-pos-error text-white font-bold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20 active:scale-95">
                <i data-lucide="file-type-2" class="size-5"></i>
                <span>PDF</span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm">
        <div class="flex items-center gap-3 mb-8">
            <div class="size-10 rounded-xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-pos-secondary">
                <i data-lucide="filter" class="size-5"></i>
            </div>
            <h3 class="text-lg font-black text-pos-foreground tracking-tight">Filter Laporan</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Month Filter -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Berdasarkan Bulan</label>
                 <div class="relative">
                    <i data-lucide="calendar-days" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary/40"></i>
                    <select wire:model.live="selectedMonth" class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-sm appearance-none cursor-pointer">
                        <option value="">Pilih Bulan...</option>
                        @foreach($availableMonths as $month)
                            <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Custom Range -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Dari Tanggal</label>
                <input type="date" wire:model.live="from" class="w-full h-14 px-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-sm">
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Sampai Tanggal</label>
                <input type="date" wire:model.live="to" class="w-full h-14 px-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-pos-foreground font-bold text-sm">
            </div>
        </div>

        @if($selectedMonth || $from || $to)
            <div class="mt-8 p-4 rounded-2xl bg-primary-blue/5 border border-primary-blue/10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="info" class="size-5 text-primary-blue"></i>
                    <span class="text-sm font-bold text-primary-blue">
                        @if($selectedMonth)
                            Menampilkan laporan periode {{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->locale('id')->translatedFormat('F Y') }}
                        @else
                            Menampilkan laporan dari {{ \Carbon\Carbon::parse($from)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($to)->translatedFormat('d M Y') }}
                        @endif
                    </span>
                </div>
                <button wire:click="$set('selectedMonth', ''); $set('from', ''); $set('to', '')" class="text-[10px] font-black text-primary-blue uppercase hover:underline">Reset Filter</button>
            </div>
        @endif
    </div>

     <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm hover:shadow-xl transition-all group overflow-hidden relative">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i data-lucide="sun" class="size-20"></i>
            </div>
            <div class="flex flex-col gap-4">
                <div class="size-14 rounded-2xl bg-pos-success/10 flex items-center justify-center text-pos-success">
                    <i data-lucide="wallet" class="size-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest">Pendapatan Hari Ini</p>
                    <h3 class="text-3xl font-black text-pos-foreground">Rp {{ number_format($dailyTotal ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm hover:shadow-xl transition-all group overflow-hidden relative">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i data-lucide="calendar" class="size-20"></i>
            </div>
            <div class="flex flex-col gap-4">
                <div class="size-14 rounded-2xl bg-primary-blue/10 flex items-center justify-center text-primary-blue">
                    <i data-lucide="pie-chart" class="size-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest">Pendapatan Bulan Ini</p>
                    <h3 class="text-3xl font-black text-pos-foreground">Rp {{ number_format($monthlyTotal ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

     <!-- Table -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-pos-card-grey/50 dark:bg-pos-muted/10">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest w-16 text-center">No</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Invoice</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Tanggal & Staff</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-center">Meja</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Metode</th>
                        <th class="px-8 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Total</th>
                    </tr>
                </thead>
                 <tbody class="divide-y divide-pos-border dark:divide-zinc-800">
                    @forelse($orders as $index => $order)
                        <tr class="hover:bg-pos-muted/20 dark:hover:bg-pos-muted/5 transition-colors group">
                            <td class="px-8 py-5 text-center">
                                <span class="text-xs font-bold text-pos-secondary">{{ $orders->firstItem() + $index }}</span>
                            </td>
                            <td class="px-8 py-5 font-black text-sm text-pos-foreground group-hover:text-primary-blue transition-colors uppercase">
                                #{{ $order->no_order }}
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-bold text-pos-foreground">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest mt-0.5">{{ $order->user?->name ?? 'System' }}</p>
                            </td>
                             <td class="px-8 py-5 text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary text-[10px] font-black uppercase tracking-widest">
                                    {{ $order->table ? $order->table->code : 'Umum' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right font-bold text-xs uppercase tracking-widest text-pos-foreground">
                                {{ $order->payment_method }}
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-base font-black text-primary-blue">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-pos-secondary/30">
                                <div class="flex flex-col items-center gap-4">
                                    <i data-lucide="database-zap" class="size-12"></i>
                                    <p class="font-black">Tidak ada data transaksi untuk filter ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
         @if($orders->hasPages())
            <div class="px-8 py-6 bg-pos-card-grey/30 dark:bg-pos-muted/10 border-t border-pos-border dark:border-zinc-800 flex items-center justify-between">
                <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">Total <span class="text-primary-blue">{{ $orders->total() }}</span> Transaksi</p>
                {{ $orders->links('components.pagination.premium') }}
            </div>
        @endif
    </div>
</div>