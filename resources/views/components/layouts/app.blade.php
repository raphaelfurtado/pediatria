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

    {{-- Consentimento de cookies (LGPD) --}}
    <div x-data="{ show: false }" x-init="show = ! localStorage.getItem('cookie_consent')" x-show="show"
        style="display: none;" class="fixed bottom-0 inset-x-0 z-[60] p-4">
        <div
            class="container mx-auto max-w-4xl bg-secondary text-white rounded-2xl shadow-2xl p-5 flex flex-col md:flex-row md:items-center gap-4">
            <p class="text-sm text-blue-100 flex-1">
                Usamos cookies para melhorar sua experiência e analisar o tráfego do site. Ao continuar navegando, você
                concorda com nossa
                <a href="{{ route('pages.privacy') }}" class="underline font-bold text-accent">Política de
                    Privacidade</a>.
            </p>
            <div class="flex gap-3 flex-shrink-0">
                <a href="{{ route('pages.privacy') }}"
                    class="text-sm font-bold text-blue-200 hover:text-white px-4 py-2 self-center">Saiba mais</a>
                <button type="button" @click="localStorage.setItem('cookie_consent', '1'); show = false"
                    class="bg-accent text-secondary font-bold text-sm px-6 py-2 rounded-full hover:bg-white transition-colors whitespace-nowrap">
                    Aceitar
                </button>
            </div>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>