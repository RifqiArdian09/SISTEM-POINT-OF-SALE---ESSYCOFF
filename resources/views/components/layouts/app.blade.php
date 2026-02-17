@php
    $user = auth()->user();
    $role = $user->role ?? null;
@endphp

<x-layouts.app.sidebar :title="$title ?? null">
    {{ $slot }}
</x-layouts.app.sidebar>