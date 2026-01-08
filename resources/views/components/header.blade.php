<div class="bg-gradient-to-r from-secondary to-primary text-white py-2 text-xs font-bold tracking-wide">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center gap-6">
            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">mail</span>
                atendimento.sopape@gmail.com</span>
            <span class="hidden md:flex items-center gap-2"><span class="material-symbols-outlined text-sm">call</span>
                (91) 99999-9999</span>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a class="hover:text-accent transition-colors flex items-center gap-1"
                    href="{{ route('member.dashboard') }}"><span class="material-symbols-outlined text-sm">person</span>
                    Minha Conta</a>
                <div class="h-3 w-px bg-white/30"></div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-accent transition flex items-center gap-1"><span
                            class="material-symbols-outlined text-sm">logout</span> Sair</button>
                </form>
            @else
                <a class="hover:text-accent transition-colors flex items-center gap-1" href="{{ route('login') }}"><span
                        class="material-symbols-outlined text-sm">lock</span> Área do Associado</a>
            @endauth

            <div class="h-3 w-px bg-white/30"></div>
            <div class="flex gap-3">
                <a class="hover:text-accent transition" href="#"><span
                        class="material-symbols-outlined text-sm">facebook</span></a>
                <!-- Using icon name since material symbols font is loaded -->
                <a class="hover:text-accent transition" href="#"><span
                        class="material-symbols-outlined text-sm">photo_camera</span></a>
            </div>
        </div>
    </div>
</div>
<header class="sticky top-0 z-50 glass-effect shadow-sm transition-all duration-300">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <a class="flex items-center gap-3 group" href="{{ route('home') }}">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-all duration-300">
                    <span class="material-symbols-outlined text-2xl">child_care</span>
                </div>
                <div class="flex flex-col">
                    <span
                        class="font-heading font-extrabold text-xl md:text-2xl text-secondary leading-tight tracking-tight group-hover:text-primary transition-colors">SOPAPE</span>
                    <span
                        class="text-[0.6rem] md:text-xs text-gray-500 font-bold uppercase tracking-widest leading-none">Sociedade
                        Paraense de Pediatria</span>
                </div>
            </a>
            <nav class="hidden xl:flex items-center gap-6">
                <a class="nav-link {{ request()->routeIs('home') ? 'text-primary after:w-1/2' : '' }}"
                    href="{{ route('home') }}">Home</a>
                <a class="nav-link {{ request()->routeIs('pages.about') ? 'text-primary after:w-1/2' : '' }}"
                    href="{{ route('pages.about') }}">Institucional</a>
                <a class="nav-link {{ request()->routeIs('publications.index') ? 'text-primary after:w-1/2' : '' }}"
                    href="{{ route('publications.index') }}">Artigos e Projetos</a>
                <a class="nav-link {{ request()->routeIs('events.index') ? 'text-primary after:w-1/2' : '' }}"
                    href="{{ route('events.index') }}">Cursos e Eventos</a>
                <a class="nav-link {{ request()->routeIs('posts.index') ? 'text-primary after:w-1/2' : '' }}"
                    href="{{ route('posts.index') }}">Notícias</a>
                <a class="nav-link" href="#">Livros</a>
                <a class="nav-link" href="#">Links</a>
                <a class="nav-link" href="#">Contato</a>
            </nav>
            <div class="flex items-center gap-3">
                <button
                    class="w-10 h-10 rounded-full border border-gray-200 hover:bg-gray-50 text-gray-500 transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined">search</span>
                </button>
                @guest
                    <a class="hidden md:flex bg-accent hover:bg-yellow-400 text-secondary px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-yellow-500/20 transition-all hover:-translate-y-0.5 items-center gap-2"
                        href="{{ route('register') }}">
                        <span class="material-symbols-outlined text-lg">star</span> Seja Sócio
                    </a>
                @endguest
                <button class="xl:hidden p-2 text-secondary">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>
            </div>
        </div>
    </div>
</header>