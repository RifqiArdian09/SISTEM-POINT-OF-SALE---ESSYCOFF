<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Transaksi EssyCoff</title>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            background-color: #ffffff;
        }

        .container {
            padding: 40px;
        }

        /* Top Header Aesthetic */
        .page-header {
            background-color: #165DFF;
            color: #ffffff;
            padding: 40px;
            margin-bottom: 30px;
        }

        .page-header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            margin: 0;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
            margin-top: 5px;
        }

        .period-box {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            border-radius: 12px;
            margin-top: 20px;
            display: inline-block;
        }

        /* Stats Grid */
        .stats-grid {
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 20px;
            width: 30%;
            float: left;
            margin-right: 3%;
        }

        .stat-label {
            font-size: 9px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Tables */
        .table-section {
            margin-top: 20px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border-left: 4px solid #165DFF;
            padding-left: 12px;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.main-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }

        table.main-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 800; }
        .text-blue { color: #165DFF; }

        /* Status Badge */
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .badge-success { background-color: #dcfce7; color: #166534; }

        /* Footer */
        .pdf-footer {
            margin-top: 40px;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="page-header">
        <table>
            <tr>
                <td>
                    <h1 class="header-title">EssyCoff</h1>
                    <p class="header-subtitle">Laporan Penjualan & Transaksi Harian</p>
                </td>
                <td class="text-right">
                    <div style="font-size: 10px; opacity: 0.7;">Tanggal Cetak:</div>
                    <div style="font-weight: 800; font-size: 12px;">{{ now()->translatedFormat('d F Y') }}</div>
                </td>
            </tr>
        </table>

        <div class="period-box">
            <span style="opacity: 0.7; font-size: 9px; display: block; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px;">Periode Laporan</span>
            <span style="font-weight: 800;">
                {{ \Carbon\Carbon::parse($fromDate)->translatedFormat('d F Y') }} 
                &nbsp;—&nbsp; 
                {{ \Carbon\Carbon::parse($toDate)->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <div class="container">
        @php
            $paidOrders = collect($orders ?? [])->filter(fn($o) => ($o->status ?? null) === 'paid');
            $totalPaid = $paidOrders->sum('total');
            $totalTrx = $paidOrders->count();
            $avgValue = $totalTrx > 0 ? $totalPaid / $totalTrx : 0;
            $byMethod = $paidOrders->groupBy('payment_method')->map->sum('total');
        @endphp

        <!-- Summary Statistics -->
        <div class="stats-grid clearfix">
            <div class="stat-card">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value text-blue">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Volume Transaksi</div>
                <div class="stat-value">{{ number_format($totalTrx, 0, ',', '.') }} <span style="font-size: 10px; font-weight: 400; color: #64748b;">Order</span></div>
            </div>
            <div class="stat-card" style="margin-right:0;">
                <div class="stat-label">Rata-rata / Order</div>
                <div class="stat-value">Rp {{ number_format($avgValue, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="table-section">
            <h2 class="section-title">Daftar Transaksi Selesai (Paid)</h2>
            <table class="main-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">ID Pesanan</th>
                        <th style="width: 20%;">Waktu & Tanggal</th>
                        <th style="width: 20%;">Kasir</th>
                        <th style="width: 15%;">Metode</th>
                        <th class="text-right" style="width: 25%;">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paidOrders as $order)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="font-bold">#{{ $order->no_order }}</td>
                            <td>{{ $order->created_at->format('H:i') }} <span style="color: #64748b; font-size: 9px;">• {{ $order->created_at->format('d/m/y') }}</span></td>
                            <td>{{ $order->user?->name ?? 'System' }}</td>
                            <td class="text-center"><span class="badge badge-success" style="background: #f1f5f9; color: #475569;">{{ strtoupper($order->payment_method) }}</span></td>
                            <td class="text-right font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 40px; color: #94a3b8;">Tidak ada data transaksi ditemukan untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Payment Breakdown -->
        <div style="margin-top: 10px;">
            <h2 class="section-title">Ringkasan Metode Pembayaran</h2>
            <table style="width: 300px; border-collapse: collapse;">
                @foreach(['CASH', 'QRIS', 'CARD'] as $method)
                    @php $val = $byMethod[$method] ?? 0; @endphp
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 700;">{{ $method }}</td>
                        <td style="padding: 8px 0; padding-left: 20px; text-align: right; font-weight: 800; color: #0f172a;">Rp {{ number_format($val, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr style="border-top: 2px solid #f1f5f9;">
                    <td style="padding: 12px 0; font-weight: 800; color: #165DFF; text-transform: uppercase;">Total</td>
                    <td style="padding: 12px 0; padding-left: 20px; text-align: right; font-weight: 800; color: #165DFF; font-size: 14px;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="pdf-footer">
            Dokumen ini dihasilkan secara otomatis oleh <strong>Sistem POS EssyCoff Premium</strong>.<br>
            Cetak: {{ now()->translatedFormat('d F Y H:i:s') }}
        </div>
    </div>

</body>
</html>