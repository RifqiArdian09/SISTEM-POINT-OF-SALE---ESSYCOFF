@php
    $siteName = config('app.name', 'EssyCoff');

    $routeTitles = [
        'dashboard' => __('Dashboard'),
        'categories.index' => __('Kategori Produk'),
        'categories.create' => __('Tambah Kategori'),
        'categories.edit' => __('Edit Kategori'),
        'products.index' => __('Daftar Menu'),
        'products.create' => __('Tambah Menu'),
        'products.edit' => __('Edit Menu'),
        'users.index' => __('Karyawan & Akses'),
        'users.create' => __('Tambah Karyawan'),
        'users.edit' => __('Edit Karyawan'),
        'pos.cashier' => __('Point of Sale'),
        'pos.history' => __('Riwayat Transaksi'),
        'pos.tables' => __('Manajemen Meja'),
        'report.index' => __('Laporan Penjualan'),
        'settings.profile' => __('Profil Saya'),
        'settings.password' => __('Ubah Password'),
        'settings.appearance' => __('Tampilan POS'),
    ];

    $pageTitle = trim($title ?? '') ?: ($routeTitles[request()->route()?->getName()] ?? '');
    $fullTitle = $pageTitle ? $pageTitle.' - '.$siteName : $siteName;
    $faviconUrl = asset('images/logo.png');
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $fullTitle }}</title>

<link rel="icon" href="{{ $faviconUrl }}" type="image/png">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script src="https://unpkg.com/lucide@0.454.0/dist/umd/lucide.min.js"></script>
<script>
    function initIcons() {
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    // Run on initial load and navigation
    document.addEventListener('DOMContentLoaded', initIcons);
    document.addEventListener('livewire:navigated', initIcons);

    // Livewire v3 Specific Hooks from user snippet
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('morph.updated', ({ el, component }) => {
            initIcons();
        });
        
        Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
            succeed(({ snapshot, effect }) => {
                // Use a small delay to ensure DOM is fully morphed
                setTimeout(initIcons, 10);
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@fluxAppearance
