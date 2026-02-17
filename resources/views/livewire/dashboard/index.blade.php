<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans animate-fade-in">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Dashboard Utama</h1>
            <p class="text-pos-secondary font-medium mt-1">Sistem Kendali <span class="text-primary-blue font-bold">EssyCoff Central</span>. Beroperasi secara optimal.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-5 py-3 bg-white dark:bg-pos-card-grey rounded-2xl border border-pos-border dark:border-zinc-800 shadow-sm flex items-center gap-3">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="calendar" class="size-4"></i>
                </div>
                <span class="text-sm font-black text-pos-foreground" x-data="{ date: '{{ now()->locale('id')->translatedFormat('d F Y, H:i:s') }}' }" x-init="setInterval(() => { date = new Date().toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }) }, 1000)" x-text="date"></span>
            </div>
        </div>
    </div>

    <!-- Stats Grid (5 Columns like user request) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Revenue Stat -->
        <div class="flex flex-col rounded-3xl border border-pos-border dark:border-zinc-800 p-6 gap-4 bg-white dark:bg-pos-card-grey transition-all hover:shadow-xl hover:shadow-primary-blue/5 group">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-pos-success/10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="banknote" class="size-5 text-pos-success"></i>
                </div>
                <p class="font-black text-[10px] text-pos-secondary uppercase tracking-[0.15em]">Omzet Hari Ini</p>
            </div>
            <div class="flex flex-col">
                <p class="font-black text-xl text-pos-foreground">Rp {{ number_format($totalRevenueToday, 0, ',', '.') }}</p>
                <div class="flex items-center gap-1 mt-1">
                    <i data-lucide="{{ $revenueGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="size-3 {{ $revenueGrowth >= 0 ? 'text-pos-success' : 'text-pos-error' }}"></i>
                    <span class="text-[9px] font-black {{ $revenueGrowth >= 0 ? 'text-pos-success' : 'text-pos-error' }}">{{ number_format(abs($revenueGrowth), 1) }}%</span>
                </div>
            </div>
        </div>

        <!-- Orders Stat -->
        <div class="flex flex-col rounded-3xl border border-pos-border dark:border-zinc-800 p-6 gap-4 bg-white dark:bg-pos-card-grey transition-all hover:shadow-xl hover:shadow-primary-blue/5 group">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-primary-blue/10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="shopping-cart" class="size-5 text-primary-blue"></i>
                </div>
                <p class="font-black text-[10px] text-pos-secondary uppercase tracking-[0.15em]">Transaksi</p>
            </div>
            <div class="flex flex-col">
                <p class="font-black text-2xl text-pos-foreground">{{ $totalOrdersToday }}</p>
                <p class="text-[9px] font-bold text-pos-secondary uppercase tracking-widest mt-1">Pemesanan</p>
            </div>
        </div>
        
        <!-- Sold Stat -->
        <div class="flex flex-col rounded-3xl border border-pos-border dark:border-zinc-800 p-6 gap-4 bg-white dark:bg-pos-card-grey transition-all hover:shadow-xl hover:shadow-primary-blue/5 group">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-pos-warning/10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="coffee" class="size-5 text-pos-warning"></i>
                </div>
                <p class="font-black text-[10px] text-pos-secondary uppercase tracking-[0.15em]">Porsi Terjual</p>
            </div>
            <p class="font-black text-2xl text-pos-foreground">{{ $totalProductsSold }}</p>
        </div>

        <!-- Pending Stat -->
        <div class="flex flex-col rounded-3xl border border-pos-border dark:border-zinc-800 p-6 gap-4 bg-white dark:bg-pos-card-grey transition-all hover:shadow-xl hover:shadow-primary-blue/5 group">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-pos-error/10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="clock" class="size-5 text-pos-error"></i>
                </div>
                <p class="font-black text-[10px] text-pos-secondary uppercase tracking-[0.15em]">Sisa Tagihan</p>
            </div>
            <div class="flex items-end justify-between">
                <p class="font-black text-2xl text-pos-foreground">{{ $statusCounts['pending_payment'] ?? 0 }}</p>
                <span class="text-[9px] bg-pos-error/10 text-pos-error px-2 py-0.5 rounded-lg font-black uppercase tracking-tighter">Pending</span>
            </div>
        </div>

        <!-- Average Ticket Stat -->
        <div class="flex flex-col rounded-3xl border border-pos-border dark:border-zinc-800 p-6 gap-4 bg-white dark:bg-pos-card-grey transition-all hover:shadow-xl hover:shadow-primary-blue/5 group">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-purple-500/10 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="target" class="size-5 text-purple-500"></i>
                </div>
                <p class="font-black text-[10px] text-pos-secondary uppercase tracking-[0.15em]">Rata-rata Order</p>
            </div>
            <p class="font-black text-xl text-pos-foreground">Rp {{ $totalOrdersToday > 0 ? number_format($totalRevenueToday / $totalOrdersToday, 0, ',', '.') : '0' }}</p>
        </div>
    </div>

    <!-- Main Content Split (2 Columns structure) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders (Pesanan Terbaru) -->
        <div class="flex flex-col rounded-[32px] border border-pos-border dark:border-zinc-800 bg-white dark:bg-pos-card-grey overflow-hidden shadow-sm">
            <div class="p-8 border-b border-pos-border dark:border-zinc-800 flex justify-between items-center bg-pos-card-grey/30 dark:bg-pos-muted/10">
                <div>
                    <h3 class="font-black text-lg text-pos-foreground tracking-tight">Pesanan Terbaru</h3>
                    <p class="text-xs text-pos-secondary font-bold uppercase tracking-widest mt-1">Log aktivitas penjual</p>
                </div>
                <a href="{{ route('pos.history') }}" wire:navigate class="p-2.5 bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 rounded-xl text-pos-secondary hover:text-primary-blue hover:border-primary-blue/30 transition-all">
                    <i data-lucide="external-link" class="size-4"></i>
                </a>
            </div>
            <div class="flex flex-col">
                 @forelse ($recentOrders as $order)
                    <div class="flex items-center gap-5 p-6 border-b border-pos-border dark:border-zinc-800 last:border-0 hover:bg-pos-muted/20 transition-all group">
                        <div class="size-14 shrink-0 rounded-2xl bg-pos-muted flex items-center justify-center text-pos-foreground border border-pos-border group-hover:bg-white group-hover:scale-105 transition-all">
                            <i data-lucide="receipt" class="size-6 text-pos-secondary"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-black text-sm text-pos-foreground truncate uppercase group-hover:text-primary-blue transition-colors">#{{ $order->no_order }}</h4>
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-[10px] text-pos-secondary flex items-center gap-1.5 font-bold">
                                    <i data-lucide="clock" class="size-3"></i>
                                    {{ $order->created_at->diffForHumans() }}
                                </span>
                                <span class="size-1 bg-pos-secondary/30 rounded-full"></span>
                                <span class="text-[10px] font-black uppercase tracking-[0.1em] {{ $order->status === 'paid' ? 'text-pos-success' : 'text-pos-warning' }}">
                                    {{ $order->status === 'paid' ? 'Selesai' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-sm text-pos-foreground">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            <p class="text-[9px] font-bold text-pos-secondary uppercase tracking-widest mt-1">{{ substr($order->customer_name ?? 'Guest', 0, 15) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center">
                        <i data-lucide="inbox" class="size-12 text-pos-secondary/20 mb-4 mx-auto"></i>
                        <p class="text-pos-secondary font-bold">Belum ada pesanan masuk.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Products (Menu Terpopuler) -->
        <div class="flex flex-col rounded-[32px] border border-pos-border dark:border-zinc-800 bg-white dark:bg-pos-card-grey overflow-hidden shadow-sm">
            <div class="p-8 border-b border-pos-border dark:border-zinc-800 flex justify-between items-center bg-pos-card-grey/30 dark:bg-pos-muted/10">
                <div>
                    <h3 class="font-black text-lg text-pos-foreground tracking-tight">Menu Terlaris</h3>
                    <p class="text-xs text-pos-secondary font-bold uppercase tracking-widest mt-1">Berdasarkan volume penjualan</p>
                </div>
                <div class="p-2.5 bg-primary-blue/10 rounded-xl">
                    <i data-lucide="trending-up" class="size-4 text-primary-blue"></i>
                </div>
            </div>
            <div class="flex flex-col">
                 @forelse ($topProducts as $index => $item)
                    <div class="flex items-center gap-5 p-6 border-b border-pos-border dark:border-zinc-800 last:border-0 hover:bg-pos-muted/20 transition-all group">
                        <div class="relative size-14 shrink-0 overflow-hidden rounded-2xl border border-pos-border dark:border-zinc-800 bg-pos-muted dark:bg-pos-muted/50 shadow-sm group-hover:scale-105 transition-transform">
                            @if($item->product?->image_url)
                                <img src="{{ $item->product->image_url }}" class="h-full w-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-pos-secondary/20">
                                    <i data-lucide="coffee" class="size-6"></i>
                                </div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 bg-primary-blue/90 text-[8px] font-black text-white text-center py-0.5 tracking-widest">
                                TOP {{ $index + 1 }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-black text-sm text-pos-foreground truncate capitalize group-hover:text-primary-blue transition-colors">{{ $item->product?->name ?? 'Menu Dihapus' }}</h4>
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-[10px] text-primary-blue font-black flex items-center gap-1.5 uppercase tracking-widest">
                                    <i data-lucide="tag" class="size-3"></i>
                                    {{ $item->total_sold }} Terjual
                                </span>
                                <span class="size-1 bg-pos-secondary/30 rounded-full"></span>
                                <span class="text-[10px] text-pos-secondary font-bold uppercase tracking-widest">{{ $item->product?->category?->name ?? 'General' }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-sm text-pos-foreground">Rp {{ number_format($item->product?->price ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center">
                        <i data-lucide="bar-chart-3" class="size-12 text-pos-secondary/20 mb-4 mx-auto"></i>
                        <p class="text-pos-secondary font-bold">Data penjualan belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- High Performer Charts (New Addition for visual depth) -->
    <div class="flex flex-col rounded-[48px] border border-pos-border dark:border-zinc-800 bg-white dark:bg-pos-card-grey overflow-hidden shadow-sm">
        <div class="p-10 border-b border-pos-border dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-pos-card-grey/30 dark:bg-pos-muted/10">
            <div>
                <h3 class="font-black text-2xl text-pos-foreground tracking-tight italic">E-Performance Analytics</h3>
                <p class="text-xs text-pos-secondary font-bold uppercase tracking-[0.3em] mt-1">Evolusi Arus Kas & Tren Penjualan</p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-pos-card-grey px-5 py-3 rounded-2xl border border-pos-border dark:border-zinc-800 text-[10px] font-black uppercase tracking-widest text-pos-secondary">
                <i data-lucide="zap" class="size-4 text-pos-warning animate-pulse"></i>
                Real-time Monitoring
            </div>
        </div>
        <div class="p-10">
            <div class="h-80 w-full relative">
                <canvas id="chartPendapatan"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions (User requested structure) -->
    <div class="space-y-6">
        <div class="flex items-center justify-between px-2">
            <div>
                <h3 class="font-black text-lg text-pos-foreground tracking-tight">Tindakan Cepat</h3>
                <p class="text-xs text-pos-secondary font-bold uppercase tracking-widest mt-1">Akses fitur utama dalam satu klik</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Create Product -->
            <a href="{{ route('products.create') }}" wire:navigate class="group p-8 rounded-[32px] bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 hover:border-primary-blue/50 hover:shadow-2xl hover:shadow-primary-blue/10 transition-all flex flex-col gap-6">
                <div class="size-14 bg-primary-blue/10 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:bg-primary-blue group-hover:text-white transition-all shadow-inner">
                    <i data-lucide="plus-circle" class="size-7 text-primary-blue group-hover:text-white transition-colors"></i>
                </div>
                <div>
                    <h4 class="font-black text-base text-pos-foreground mb-1 tracking-tight">Tambah Menu</h4>
                    <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Daftarkan produk atau paket kopi baru ke dalam sistem.</p>
                </div>
            </a>

            <!-- Manage Tables -->
            <a href="{{ route('pos.tables') }}" wire:navigate class="group p-8 rounded-[32px] bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 hover:border-purple-500/50 hover:shadow-2xl hover:shadow-purple-500/10 transition-all flex flex-col gap-6">
                <div class="size-14 bg-purple-500/10 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all shadow-inner">
                    <i data-lucide="armchair" class="size-7 text-purple-500 group-hover:text-white transition-colors"></i>
                </div>
                <div>
                    <h4 class="font-black text-base text-pos-foreground mb-1 tracking-tight">Atur Meja</h4>
                    <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Kelola layout meja dan cetak QR code self-service.</p>
                </div>
            </a>

            <!-- Financial Report -->
            <a href="{{ route('report.index') }}" wire:navigate class="group p-8 rounded-[32px] bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 hover:border-pos-success/50 hover:shadow-2xl hover:shadow-pos-success/10 transition-all flex flex-col gap-6">
                <div class="size-14 bg-pos-success/10 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:bg-pos-success group-hover:text-white transition-all shadow-inner">
                    <i data-lucide="file-bar-chart" class="size-7 text-pos-success group-hover:text-white transition-colors"></i>
                </div>
                <div>
                    <h4 class="font-black text-base text-pos-foreground mb-1 tracking-tight">Laporan Omzet</h4>
                    <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Lihat statistik penjualan dan ekspor data ke Excel/PDF.</p>
                </div>
            </a>

            <!-- Team / Users -->
            <a href="{{ route('users.index') }}" wire:navigate class="group p-8 rounded-[32px] bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 hover:border-pos-warning/50 hover:shadow-2xl hover:shadow-pos-warning/10 transition-all flex flex-col gap-6">
                <div class="size-14 bg-pos-warning/10 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:bg-pos-warning group-hover:text-white transition-all shadow-inner">
                    <i data-lucide="users" class="size-7 text-pos-warning group-hover:text-white transition-colors"></i>
                </div>
                <div>
                    <h4 class="font-black text-base text-pos-foreground mb-1 tracking-tight">Kelola Tim</h4>
                    <p class="text-[11px] text-pos-secondary font-medium leading-relaxed">Atur hak akses karyawan (Kasir vs Manager) dan profil.</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Chart.js Logic -->
    <script>
        // Gunakan pendengar global yang menangani wire:navigate
        function setupDashboardChart() {
            const chartEl = document.getElementById('chartPendapatan');
            if (!chartEl) return;

            const ctx = chartEl.getContext('2d');
            if (chartEl.chart) {
                chartEl.chart.destroy();
            }

            const labels = @json(collect($currentMonthDays)->pluck('date'));
            const data = @json(collect($currentMonthDays)->pluck('total'));

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(22, 93, 255, 0.4)');
            gradient.addColorStop(1, 'rgba(22, 93, 255, 0.0)');

            chartEl.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Gross Revenue',
                        data: data,
                        borderColor: '#165DFF',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 6,
                        pointRadius: 0,
                        pointHoverRadius: 10,
                        pointHoverBackgroundColor: '#165DFF',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleFont: { family: 'Lexend Deca', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Lexend Deca', size: 16, weight: '900' },
                            padding: 16,
                            cornerRadius: 24,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { 
                                color: '#94A3B8',
                                font: { family: 'Lexend Deca', size: 10, weight: 'bold' },
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 7
                            },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#94A3B8',
                                font: { family: 'Lexend Deca', size: 10, weight: 'bold' },
                                callback: function(value) {
                                    if(value >= 1000000) return (value/1000000) + 'M';
                                    if(value >= 1000) return (value/1000) + 'K';
                                    return value;
                                }
                            },
                            grid: { color: '#F1F5F9', drawBorder: false }
                        }
                    }
                }
            });
        }

        // Jalankan saat pertama kali Livewire inisialisasi
        document.addEventListener('livewire:init', setupDashboardChart);
        
        // Jalankan setiap kali navigasi selesai (wire:navigate)
        document.addEventListener('livewire:navigated', setupDashboardChart);

        // Jalankan juga jika ada pembaruan DOM (seperti polling)
        document.addEventListener('livewire:dom:updated', setupDashboardChart);
    </script>

    <style>
        .animate-fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
