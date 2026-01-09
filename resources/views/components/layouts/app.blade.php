<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' . config('app.name', 'SOPAPE') : config('app.name', 'SOPAPE') }}</title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;500;700&family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0096C7", // Pacific Blue
                        primaryLight: "#48CAE4",
                        secondary: "#023E8A", // Royal Blue
                        accent: "#FFB703", // Honey Yellow
                        tertiary: "#FB8500", // Orange
                        success: "#2A9D8F", // Teal
                        rose: "#E63946", // Red/Pink
                        "surface-light": "#F8FAFC",
                        "surface-card": "#FFFFFF",
                        // Keep legacy colors for compatibility during migration if needed
                        "sopape-blue": "#023E8A",
                        "sopape-yellow": "#FFB703",
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    borderRadius: {
                        '4xl': '2.5rem',
                        '5xl': '3rem',
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(0,0,0,0.05)',
                        'hover': '0 20px 40px -10px rgba(0, 150, 199, 0.15)',
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
                .text-shadow {
                    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .glass-effect {
                    @apply bg-white/90 backdrop-blur-md border border-white/40;
                }
                .blob-bg {
                    background-image: radial-gradient(#48CAE4 1px, transparent 1px);
                    background-size: 20px 20px;
                }
            }
            .nav-link {
                @apply relative text-gray-600 hover:text-primary transition-colors font-bold text-sm uppercase tracking-wide py-2;
            }
            .nav-link::after {
                content: '';
                @apply absolute bottom-0 left-0 w-0 h-1 bg-accent rounded-full transition-all duration-300;
            }
            .nav-link:hover::after {
                @apply w-1/2;
            }
        </style>
    @livewireStyles
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