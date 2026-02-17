<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-pos-muted font-sans antialiased text-pos-foreground" x-data="{ openSidebar: false, showLogoutModal: false }">

    @if(auth()->check() && !request()->routeIs('home'))
        @php
            $user = auth()->user();
            $isManager = $user && $user->role === 'manager';
            $isCashier = $user && $user->role === 'cashier';
            
            // Badge data
            $pendingCount = $pendingCount ?? 0;
            $lowStockCount = $lowStockCount ?? 0;
            $outOfStockCount = $outOfStockCount ?? 0;
        @endphp

        <!-- Mobile Header -->
        <header class="h-[70px] lg:hidden bg-white dark:bg-pos-card-grey border-b border-pos-border px-4 flex items-center justify-between sticky top-0 z-50">
            <div class="flex items-center gap-3">
                <button @click="openSidebar = true" class="size-10 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-border/50 text-pos-foreground hover:bg-pos-border transition-colors">
                    <i data-lucide="menu" class="size-6"></i>
                </button>
                <div class="size-9 bg-primary-blue rounded-lg flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/logo2.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="font-black text-lg tracking-tight uppercase">EssyCoff</span>
            </div>

            <div class="flex items-center gap-2">
                @if($pendingCount > 0)
                    <a href="{{ route('pos.history') }}" class="size-10 flex items-center justify-center rounded-xl bg-pos-success/10 text-pos-success relative" wire:navigate>
                        <i data-lucide="history" class="size-5"></i>
                        <span class="absolute -top-1 -right-1 size-5 bg-pos-success text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white">{{ $pendingCount }}</span>
                    </a>
                @endif
            </div>
        </header>

        <div class="flex h-screen overflow-hidden">
            <!-- Mobile Sidebar Overlay -->
            <div x-show="openSidebar" 
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-pos-foreground/60 backdrop-blur-sm z-[60] lg:hidden"
                @click="openSidebar = false"
                style="display: none;"
            ></div>

            <!-- MAIN SIDEBAR -->
            <aside id="sidebar" 
                class="flex flex-col w-[280px] shrink-0 h-screen fixed lg:static inset-y-0 left-0 z-[70] bg-white dark:bg-pos-card-grey border-r border-pos-border transform transition-transform duration-300 ease-in-out lg:translate-x-0"
                :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
            >
                <!-- Logo Section -->
                <div class="flex flex-col justify-center h-[120px] px-8 border-b border-pos-border">
                    <a href="{{ $isCashier ? route('pos.cashier') : route('dashboard') }}" class="flex items-center gap-4 group" wire:navigate>
                        <div class="size-12 bg-white dark:bg-pos-muted rounded-2xl flex items-center justify-center shadow-xl shadow-primary-blue/10 group-hover:scale-105 transition-transform overflow-hidden border border-pos-border">
                            <img src="{{ asset('images/logo2.png') }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h1 class="font-black text-xl tracking-tighter text-pos-foreground uppercase leading-none">ESSYCOFF</h1>
                            <p class="text-[9px] font-black text-pos-secondary uppercase tracking-[0.1em] mt-1.5 leading-none">Sistem Point of Sale</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Section (Flat, No Dropdown) -->
                <div class="flex flex-col p-4 gap-8 overflow-y-auto flex-1 no-scrollbar">
                    @if($isManager)
                    <!-- Section: Manajemen -->
                    <div class="flex flex-col gap-2">
                        <h3 class="px-4 text-[10px] font-black text-pos-secondary uppercase tracking-[0.2em] mb-1">Pusat Kendali</h3>
                        <div class="flex flex-col gap-1">
                            <x-sidebar.item-premium icon="layout-grid" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" label="E-Dashboard" />
                            <x-sidebar.item-premium icon="layers" href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')" label="Kategori" />
                            <x-sidebar.item-premium icon="coffee" href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" label="Katalog Menu" :badge="($lowStockCount + $outOfStockCount) > 0 ? ($lowStockCount + $outOfStockCount) : null" badgeType="error" />
                            <x-sidebar.item-premium icon="shield-check" href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" label="Manajemen Tim" />
                        </div>
                    </div>

                    <!-- Section: Laporan -->
                    <div class="flex flex-col gap-2">
                        <h3 class="px-4 text-[10px] font-black text-pos-secondary uppercase tracking-[0.2em] mb-1">Analisis Finansial</h3>
                        <div class="flex flex-col gap-1">
                            <x-sidebar.item-premium icon="bar-chart-3" href="{{ route('report.index') }}" :active="request()->routeIs('report.*')" label="Laporan Omzet" />
                        </div>
                    </div>
                    @endif

                    @if($isCashier || $isManager)
                    <!-- Section: POS -->
                    <div class="flex flex-col gap-2">
                        <h3 class="px-4 text-[10px] font-black text-pos-secondary uppercase tracking-[0.2em] mb-1">Point of Sale</h3>
                        <div class="flex flex-col gap-1">
                            <x-sidebar.item-premium icon="shopping-cart" href="{{ route('pos.cashier') }}" :active="request()->routeIs('pos.cashier')" label="Order Baru" />
                            <x-sidebar.item-premium icon="armchair" href="{{ route('pos.tables') }}" :active="request()->routeIs('pos.tables')" label="Layout Meja" />
                            <x-sidebar.item-premium icon="history" href="{{ route('pos.history') }}" :active="request()->routeIs('pos.history')" label="Arus Aktivitas" :badge="$pendingCount > 0 ? $pendingCount : null" badgeType="success" />
                        </div>
                    </div>

                    <!-- Section: Pengaturan -->
                    <div class="flex flex-col gap-2">
                        <h3 class="px-4 text-[10px] font-black text-pos-secondary uppercase tracking-[0.2em] mb-1">Konfigurasi</h3>
                        <div class="flex flex-col gap-1">
                            <x-sidebar.item-premium icon="user-circle" href="{{ route('settings.profile') }}" :active="request()->routeIs('settings.profile')" label="Profil Saya" />
                            <x-sidebar.item-premium icon="lock" href="{{ route('settings.password') }}" :active="request()->routeIs('settings.password')" label="Keamanan" />
                            @if($isManager)
                                <x-sidebar.item-premium icon="palette" href="{{ route('settings.appearance') }}" :active="request()->routeIs('settings.appearance')" label="Tampilan POS" />
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Bottom Actions -->
                <div class="p-4 border-t border-pos-border bg-pos-card-grey/30 dark:bg-pos-muted/20">
                    <div class="bg-white dark:bg-pos-muted/40 rounded-[24px] p-4 border border-pos-border shadow-sm flex items-center gap-3 mb-4">
                        <div class="size-10 rounded-xl bg-pos-muted flex items-center justify-center font-black text-primary-blue border border-primary-blue/10 uppercase text-xs">
                            {{ auth()->user()->initials() }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-black text-pos-foreground truncate uppercase tracking-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[9px] text-pos-secondary font-black uppercase tracking-widest truncate mt-0.5">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    
                    <button @click="showLogoutModal = true" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-[18px] text-pos-error hover:bg-pos-error/5 font-black text-[10px] uppercase tracking-widest transition-all group">
                        <i data-lucide="log-out" class="size-4 group-hover:translate-x-1 transition-transform"></i>
                        <span>Keluar Sesi</span>
                    </button>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto h-screen custom-scroll bg-pos-muted relative">
                {{ $slot }}
            </main>
        </div>

        <!-- Logout Confirmation Modal -->
        <div x-show="showLogoutModal" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[999] flex items-center justify-center p-4"
            style="display: none;"
        >
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" @click="showLogoutModal = false"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-sm p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800"
                x-transition:enter="transition ease-out duration-300 delay-100"
                x-transition:enter-start="scale-95 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
            >
                <div class="size-20 bg-pos-warning/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="log-out" class="size-10 text-pos-warning"></i>
                </div>
                <h3 class="text-xl font-black text-pos-foreground mb-3">Keluar dari Sistem?</h3>
                <p class="text-pos-secondary text-sm mb-8 leading-relaxed">Anda akan keluar dari sesi saat ini. Pastikan semua pekerjaan telah tersimpan.</p>
                
                <div class="grid grid-cols-2 gap-3">
                    <button @click="showLogoutModal = false" class="py-3 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-bold text-sm hover:bg-pos-border dark:hover:bg-pos-muted/40 transition-all border border-pos-border dark:border-zinc-800">Batal</button>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-pos-error text-white rounded-2xl font-bold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20">Ya, Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        {{ $slot }}
    @endif

    <livewire:pos.incoming-order-notifier />

    @fluxScripts

    <!-- Global Toasts -->
    <div x-data="{
        toasts: [],
        playDing() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const o = ctx.createOscillator();
                const g = ctx.createGain();
                o.connect(g); g.connect(ctx.destination);
                o.type = 'sine'; o.frequency.value = 880;
                const now = ctx.currentTime;
                g.gain.setValueAtTime(0.001, now);
                g.gain.exponentialRampToValueAtTime(0.2, now + 0.01);
                g.gain.exponentialRampToValueAtTime(0.0001, now + 0.3);
                o.start(); o.stop(now + 0.35);
            } catch (e) {}
        },
        add(toast) {
            const id = Date.now() + Math.random();
            const payload = Array.isArray(toast) ? (toast[0] || {}) : (toast || {});
            const type = (payload.type || 'success').toLowerCase();
            const item = { id, title: payload.title || null, message: payload.message || '', type, timeout: payload.timeout || 3000, tid: null, href: payload.href || null };
            this.toasts.push(item);
            if (payload.playSound) this.playDing();
            item.tid = setTimeout(() => this.remove(id), item.timeout);
        },
        remove(id) {
            const t = this.toasts.find(tt => tt.id === id);
            if (t && t.tid) clearTimeout(t.tid);
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
        open(t) {
            if (t.href) window.location.assign(t.href);
        }
    }"
    x-on:toast.window="add($event.detail)"
    x-init="if(window.lucide) lucide.createIcons()"
    class="pointer-events-none fixed top-6 right-6 z-[100] space-y-3"
    >
        <template x-for="t in toasts" :key="t.id">
            <div
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="pointer-events-auto min-w-[320px] max-w-sm bg-white dark:bg-pos-card-grey rounded-2xl p-4 shadow-2xl border border-pos-border flex items-start gap-4 cursor-pointer hover:scale-[1.02] transition-transform"
                @click="open(t)"
            >
                <div class="shrink-0 size-10 rounded-xl flex items-center justify-center"
                    :class="{
                        'bg-pos-success/10 text-pos-success': t.type === 'success',
                        'bg-pos-error/10 text-pos-error': t.type === 'error',
                        'bg-pos-warning/10 text-pos-warning': t.type === 'warning',
                    }"
                >
                    <i :data-lucide="t.type === 'success' ? 'check-circle' : (t.type === 'error' ? 'x-circle' : 'alert-triangle')" class="size-6"></i>
                </div>
                <div class="flex-1 pt-0.5">
                    <p x-show="t.title" class="text-sm font-extrabold text-pos-foreground" x-text="t.title"></p>
                    <p class="text-xs font-medium text-pos-secondary mt-0.5 leading-relaxed" x-text="t.message"></p>
                </div>
                <button @click.stop="remove(t.id)" class="text-pos-secondary/40 hover:text-pos-foreground transition-colors">
                    <i data-lucide="x" class="size-4"></i>
                </button>
            </div>
        </template>
    </div>

    @if(session()->has('message') || session()->has('success') || session()->has('error') || session()->has('warning'))
        <div x-data x-init="
            const msg = @json(session('message') ?: session('success') ?: session('error') ?: session('warning'));
            const type = @json(session('error') ? 'error' : (session('warning') ? 'warning' : 'success'));
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('toast', { detail: { type, title: type.charAt(0).toUpperCase() + type.slice(1), message: msg } }));
            }, 100);
        "></div>
    @endif
    
</body>
</html>