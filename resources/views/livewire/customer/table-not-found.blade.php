<div class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-pos-error/20 via-pos-muted to-pos-card-grey dark:from-pos-card-grey dark:via-pos-muted dark:to-black relative overflow-hidden" x-data x-init="if (window.lucide) lucide.createIcons()">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-pos-error/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pos-warning/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="relative w-full max-w-lg bg-white dark:bg-pos-card-grey rounded-[32px] p-8 shadow-2xl border border-pos-border dark:border-zinc-800 animate-peek">
        <!-- Error Icon -->
        <div class="size-20 bg-pos-error/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="alert-triangle" class="size-10 text-pos-error"></i>
        </div>

        <!-- Title & Message -->
        <h1 class="text-2xl font-black text-pos-foreground text-center mb-2">Meja Tidak Ditemukan</h1>
        <p class="text-pos-secondary text-center text-sm mb-6">QR code mungkin tidak valid atau meja sudah dihapus dari sistem.</p>

        <!-- Table Code Display -->
        @if($tableCode)
            <div class="bg-pos-error/5 border border-pos-error/20 rounded-2xl p-4 mb-6 text-center">
                <p class="text-xs font-black text-pos-secondary uppercase tracking-widest mb-2">Kode Meja</p>
                <p class="text-2xl font-black text-pos-error font-mono">{{ $tableCode }}</p>
                <p class="text-xs text-pos-secondary mt-1">tidak tersedia di sistem</p>
            </div>
        @endif

        <!-- Available Tables -->
        @if($availableTables->count() > 0)
            <div class="mb-6">
                <h2 class="text-sm font-black text-pos-secondary uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i data-lucide="list" class="size-4"></i>
                    Meja yang Tersedia
                </h2>
                <div class="space-y-2 max-h-64 overflow-y-auto custom-scroll">
                    @foreach($availableTables as $t)
                        <a href="{{ route('customer.table', ['code' => $t->code]) }}"
                           class="group flex items-center justify-between bg-pos-muted dark:bg-pos-muted/20 hover:bg-primary-blue/10 dark:hover:bg-primary-blue/20 rounded-2xl p-4 border border-pos-border dark:border-zinc-800 hover:border-primary-blue dark:hover:border-primary-blue transition-all">
                            <div class="flex items-center gap-3">
                                <div class="size-10 bg-white dark:bg-pos-card-grey rounded-xl flex items-center justify-center border border-pos-border dark:border-zinc-800 group-hover:border-primary-blue transition-colors">
                                    <i data-lucide="armchair" class="size-5 text-pos-secondary group-hover:text-primary-blue transition-colors"></i>
                                </div>
                                <div>
                                    <p class="font-black text-pos-foreground group-hover:text-primary-blue transition-colors">{{ $t->name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 bg-white dark:bg-pos-card-grey border border-pos-border dark:border-zinc-800 rounded-lg text-[10px] font-black text-pos-secondary font-mono">{{ $t->code }}</span>
                                        @if($t->seats)
                                            <span class="px-2 py-0.5 bg-pos-success/10 border border-pos-success/20 rounded-lg text-[10px] font-black text-pos-success">{{ $t->seats }} kursi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <i data-lucide="chevron-right" class="size-5 text-pos-secondary group-hover:text-primary-blue group-hover:translate-x-1 transition-all"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Help Text -->
        <div class="bg-pos-warning/10 border border-pos-warning/20 rounded-2xl p-4 flex items-start gap-3">
            <i data-lucide="info" class="size-5 text-pos-warning shrink-0 mt-0.5"></i>
            <div class="text-sm text-pos-secondary">
                <p class="font-bold text-pos-foreground mb-1">Butuh Bantuan?</p>
                <p>Jika Anda yakin kode sudah benar, silakan hubungi kasir atau manager untuk bantuan lebih lanjut.</p>
            </div>
        </div>
    </div>
</div>