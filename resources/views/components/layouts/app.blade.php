@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title . ' | SOPAPE' : 'SOPAPE — Sociedade Paraense de Pediatria' }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;500;700&family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Scripts personalizados (Google Analytics, etc.) definidos em Configurações --}}
    {!! \App\Models\SiteSetting::get('head_scripts') !!}
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800">
    @include('components.header')

    <main>
        {{ $slot }}
    </main>

    @include('components.footer')

    @livewireScripts
    @stack('scripts')
</body>

</html>