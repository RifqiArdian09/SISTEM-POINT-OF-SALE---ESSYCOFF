<div class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-primary-blue via-pos-card-grey to-pos-muted dark:from-pos-card-grey dark:via-pos-muted dark:to-black relative overflow-hidden" x-data x-init="if (window.lucide) lucide.createIcons()">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-blue/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pos-success/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="relative w-full max-w-5xl mx-auto text-center space-y-12 animate-fade-in">
        <!-- Logo & Brand -->
        <div class="flex flex-col items-center gap-6">
            <div class="size-24 bg-white dark:bg-pos-card-grey rounded-[32px] flex items-center justify-center shadow-2xl shadow-primary-blue/20 border-4 border-white dark:border-zinc-800 animate-peek">
                <img src="{{ asset('images/logo2.png') }}" alt="EssyCoff Logo" class="w-16 h-16 rounded-2xl">
            </div>
            <div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-4">
                    Selamat Datang di <span class="text-primary-blue">EssyCoff</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/80 font-medium max-w-2xl mx-auto">
                    Nikmati pengalaman memesan kopi premium dengan mudah dan cepat
                </p>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <!-- Feature 1 -->
            <div class="bg-white/10 dark:bg-pos-card-grey/50 backdrop-blur-xl rounded-[32px] p-8 border border-white/20 dark:border-zinc-800 hover:scale-105 transition-transform duration-300">
                <div class="size-16 bg-primary-blue/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="coffee" class="size-8 text-primary-blue"></i>
                </div>
                <h3 class="text-xl font-black text-white mb-2">Kopi Premium</h3>
                <p class="text-white/70 text-sm">Biji pilihan terbaik dengan racikan khusus barista kami</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white/10 dark:bg-pos-card-grey/50 backdrop-blur-xl rounded-[32px] p-8 border border-white/20 dark:border-zinc-800 hover:scale-105 transition-transform duration-300" style="transition-delay: 100ms;">
                <div class="size-16 bg-pos-success/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="zap" class="size-8 text-pos-success"></i>
                </div>
                <h3 class="text-xl font-black text-white mb-2">Pesan Cepat</h3>
                <p class="text-white/70 text-sm">Tanpa antri, cukup pesan dari genggaman tangan</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white/10 dark:bg-pos-card-grey/50 backdrop-blur-xl rounded-[32px] p-8 border border-white/20 dark:border-zinc-800 hover:scale-105 transition-transform duration-300" style="transition-delay: 200ms;">
                <div class="size-16 bg-pos-warning/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="star" class="size-8 text-pos-warning"></i>
                </div>
                <h3 class="text-xl font-black text-white mb-2">Kualitas Terjamin</h3>
                <p class="text-white/70 text-sm">Setiap pesanan dibuat dengan standar kualitas tertinggi</p>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="flex flex-col items-center gap-4">
            <a href="{{ route('customer') }}" 
                class="group inline-flex items-center gap-3 px-12 py-5 bg-primary-blue hover:bg-primary-blue/90 text-white rounded-[24px] font-black text-lg shadow-2xl shadow-primary-blue/30 hover:shadow-primary-blue/50 transition-all hover:scale-105">
                <i data-lucide="shopping-cart" class="size-6"></i>
                <span>Mulai Pesanan</span>
                <i data-lucide="arrow-right" class="size-6 group-hover:translate-x-1 transition-transform"></i>
            </a>
            <p class="text-white/60 text-sm font-medium">
                <i data-lucide="clock" class="size-4 inline mr-1"></i>
                Buka setiap hari, 08:00 - 22:00
            </p>
        </div>
    </div>
</div>