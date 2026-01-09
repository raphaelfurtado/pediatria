@php
    $menuItems = \App\Models\MenuItem::active()->topLevel()->with('children')->orderBy('order')->get();
@endphp

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
                @foreach($menuItems as $item)
                    @if($item->children->isNotEmpty())
                        <div class="relative group h-full flex items-center">
                            <button class="nav-link flex items-center gap-1">
                                {{ $item->label }}
                                <span class="material-symbols-outlined text-xs">keyboard_arrow_down</span>
                            </button>
                            <div
                                class="absolute top-full left-0 mt-2 w-48 bg-white rounded-2xl shadow-xl py-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-slate-50">
                                @foreach($item->children->where('is_active', true) as $child)
                                    <a href="{{ $child->url ?: '#' }}"
                                        class="block px-6 py-2 text-sm text-slate-600 hover:text-primary hover:bg-slate-50 transition-colors font-bold">
                                        {{ $child->label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a class="nav-link {{ request()->url() == $item->url ? 'text-primary after:w-1/2' : '' }}"
                            href="{{ $item->url ?: '#' }}">{{ $item->label }}</a>
                    @endif
                @endforeach
            </nav>
            <div class="flex items-center gap-3" x-data="{ open: false }">
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
                <button @click="open = !open" class="xl:hidden p-2 text-secondary">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>

                <!-- Mobile Menu Drawer -->
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full" class="fixed inset-0 z-[60] xl:hidden"
                    style="display: none;" @keydown.escape.window="open = false">

                    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="open = false"></div>

                    <div class="fixed inset-y-0 right-0 w-full max-w-[320px] bg-white shadow-2xl flex flex-col h-full">
                        <div class="px-6 py-6 border-b border-slate-50 flex items-center justify-between">
                            <span class="font-heading font-extrabold text-2xl text-secondary uppercase">Menu
                                Principal</span>
                            <button @click="open = false" class="p-2 text-slate-400">
                                <span class="material-symbols-outlined text-3xl">close</span>
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-6 py-4">
                            <nav class="flex flex-col">
                                @forelse($menuItems as $item)
                                    <div x-data="{ subOpen: false }" class="border-b border-slate-50 last:border-0">
                                        <div class="flex items-center justify-between">
                                            <a href="{{ $item->url ?: '#' }}"
                                                class="flex-1 py-4 text-base font-bold text-secondary hover:text-primary transition-colors">
                                                {{ $item->label }}
                                            </a>
                                            @if($item->children->count() > 0)
                                                <button @click="subOpen = !subOpen" class="p-4 text-slate-400">
                                                    <span class="material-symbols-outlined transition-transform duration-300"
                                                        :class="subOpen ? 'rotate-180' : ''">expand_more</span>
                                                </button>
                                            @endif
                                        </div>

                                        @if($item->children->count() > 0)
                                            <div x-show="subOpen"
                                                class="pl-4 border-l-2 border-primary/20 space-y-1 mb-4 bg-slate-50/50 rounded-r-xl">
                                                @foreach($item->children->where('is_active', true) as $child)
                                                    <a href="{{ $child->url ?: '#' }}"
                                                        class="block py-3 text-sm text-slate-600 font-bold hover:text-primary transition-colors border-b border-white last:border-0">
                                                        {{ $child->label }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="py-10 text-center">
                                        <p class="text-slate-400 italic">Nenhum item encontrado ({{ count($menuItems) }})
                                        </p>
                                    </div>
                                @endforelse
                            </nav>
                        </div>

                        <div class="p-6 border-t border-slate-100 bg-slate-50">
                            @guest
                                <a href="{{ route('register') }}"
                                    class="w-full bg-accent text-secondary py-4 rounded-2xl text-center font-bold shadow-lg block">
                                    Seja Sócio
                                </a>
                            @else
                                <a href="{{ route('member.dashboard') }}"
                                    class="w-full bg-secondary text-white py-4 rounded-2xl text-center font-bold shadow-lg block">
                                    Minha Conta
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>