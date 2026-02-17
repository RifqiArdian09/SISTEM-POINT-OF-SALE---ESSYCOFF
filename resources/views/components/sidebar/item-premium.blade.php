@props([
    'icon' => 'home',
    'href' => '#',
    'active' => false,
    'label' => '',
    'badge' => null,
    'badgeType' => 'success'
])

<a href="{{ $href }}" 
    {{ $attributes->merge(['class' => 'flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group ' . ($active ? 'bg-primary-blue text-white shadow-lg shadow-primary-blue/20' : 'text-pos-secondary hover:bg-pos-muted hover:text-pos-foreground')]) }}
    @if($href !== '#') wire:navigate @endif
>
    <div class="flex items-center gap-3">
        <i data-lucide="{{ $icon }}" class="size-5 {{ $active ? 'text-white' : 'text-pos-secondary group-hover:text-primary-blue transition-colors' }}"></i>
        <span class="font-bold text-sm">{{ $label }}</span>
    </div>
    
    @if($badge)
        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-lg text-[10px] font-extrabold {{ $badgeType === 'error' ? 'bg-pos-error text-white' : 'bg-pos-success text-white' }}">
            {{ $badge }}
        </span>
    @endif
</a>
