@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'ogType' => 'website',
    'canonical' => null,
])
@php
    $siteName = 'SOPAPE — Sociedade Paraense de Pediatria';
    $fullTitle = $title ? $title . ' | SOPAPE' : $siteName;

    $defaultDescription = \App\Models\SiteSetting::get(
        'seo_description',
        'Sociedade Paraense de Pediatria (SOPAPE): notícias, eventos, publicações e ações voltadas à saúde da criança e do adolescente no Pará.'
    );
    $metaDescription = (string) \Illuminate\Support\Str::of(strip_tags($description ?: $defaultDescription))
        ->squish()
        ->limit(180);

    // Resolve absolute share image (falls back to the site-wide default in Configurações).
    $shareImage = $image ?: \App\Models\SiteSetting::get('seo_image');
    if ($shareImage && ! \Illuminate\Support\Str::startsWith($shareImage, ['http://', 'https://'])) {
        $shareImage = url($shareImage);
    }

    $canonicalUrl = $canonical ?: url()->current();

    // Site-wide Organization structured data (built from Configurações).
    $sameAs = collect([
        \App\Models\SiteSetting::get('facebook'),
        \App\Models\SiteSetting::get('instagram'),
        \App\Models\SiteSetting::get('twitter'),
    ])->filter()->values()->all();

    $organizationLd = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'MedicalOrganization',
        'name' => 'SOPAPE — Sociedade Paraense de Pediatria',
        'alternateName' => 'SOPAPE',
        'url' => url('/'),
        'logo' => url('favicon.svg'),
        'sameAs' => $sameAs ?: null,
        'email' => \App\Models\SiteSetting::get('contact_email') ?: null,
        'telephone' => \App\Models\SiteSetting::get('contact_phone') ?: null,
    ], fn ($v) => ! is_null($v));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>

    {{-- SEO --}}
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta name="robots" content="index, follow">

    {{-- Open Graph (WhatsApp, Facebook, LinkedIn) --}}
    <meta property="og:site_name" content="SOPAPE">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if($shareImage)
        <meta property="og:image" content="{{ $shareImage }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $shareImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if($shareImage)
        <meta name="twitter:image" content="{{ $shareImage }}">
    @endif

    {{-- Structured data --}}
    <script type="application/ld+json">{!! json_encode($organizationLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    {{ $seoJsonLd ?? '' }}

    {{-- Descoberta de conteúdo --}}
    <link rel="alternate" type="application/rss+xml" title="SOPAPE — Notícias" href="{{ route('feed') }}">

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

    {{-- Links dentro de conteúdo editorial (notícias, /sobre, etc.): azul + sublinhado --}}
    <style>
        .prose a,
        .article-content a {
            color: #0096C7;
            text-decoration: underline;
            font-weight: 600;
        }
        .prose a:hover,
        .article-content a:hover {
            color: #023E8A;
        }

        /* Cursor de "mãozinha" em elementos clicáveis */
        button:not(:disabled),
        [role="button"],
        summary,
        select {
            cursor: pointer;
        }
        button:disabled,
        [aria-disabled="true"] {
            cursor: not-allowed;
        }
    </style>
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