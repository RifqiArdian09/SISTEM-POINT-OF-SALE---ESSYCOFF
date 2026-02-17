<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'EssyCoff - Customer' }}</title>
</head>
<body class="min-h-screen bg-pos-muted dark:bg-pos-muted font-sans antialiased">
    {{ $slot }}

    @fluxScripts
</body>
</html>
