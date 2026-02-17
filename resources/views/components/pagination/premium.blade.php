@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-3">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center size-10 rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary/40 cursor-not-allowed border border-pos-border dark:border-zinc-800" aria-disabled="true">
                <i data-lucide="chevron-left" class="size-5"></i>
            </span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" 
                class="inline-flex items-center justify-center size-10 rounded-xl bg-white dark:bg-pos-card-grey text-pos-foreground border border-pos-border dark:border-zinc-800 hover:border-primary-blue hover:text-primary-blue transition-all shadow-sm">
                <i data-lucide="chevron-left" class="size-5"></i>
            </button>
        @endif

        <div class="flex items-center gap-2">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="text-pos-secondary px-2">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center justify-center size-10 rounded-xl bg-primary-blue text-white font-bold shadow-lg shadow-primary-blue/20">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" 
                                class="inline-flex items-center justify-center size-10 rounded-xl bg-white dark:bg-pos-card-grey text-pos-foreground border border-pos-border dark:border-zinc-800 hover:border-primary-blue hover:text-primary-blue transition-all">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" 
                class="inline-flex items-center justify-center size-10 rounded-xl bg-white dark:bg-pos-card-grey text-pos-foreground border border-pos-border dark:border-zinc-800 hover:border-primary-blue hover:text-primary-blue transition-all shadow-sm">
                <i data-lucide="chevron-right" class="size-5"></i>
            </button>
        @else
            <span class="inline-flex items-center justify-center size-10 rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary/40 cursor-not-allowed border border-pos-border dark:border-zinc-800" aria-disabled="true">
                <i data-lucide="chevron-right" class="size-5"></i>
            </span>
        @endif
    </nav>
@endif
