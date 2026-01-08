<x-layouts.app>
    <main class="min-h-screen pb-20">
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-blue-50 to-surface-light pt-12 pb-20 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full blob-bg opacity-40 pointer-events-none"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <span
                        class="text-primary font-bold uppercase tracking-widest text-xs mb-3 block animate-fade-in">Blog
                        & Atualizações</span>
                    <h1
                        class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-secondary mb-6 leading-tight">
                        Notícias, Artigos e <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Novidades</span>
                    </h1>
                    <p class="text-lg text-slate-500 font-medium max-w-2xl mx-auto">
                        Fique por dentro das últimas atualizações da pediatria, notas técnicas, artigos científicos e
                        eventos da sociedade.
                    </p>
                </div>
            </div>
        </section>

        <!-- Filters & Search -->
        <section class="container mx-auto px-6 -mt-10 relative z-20 mb-16">
            <div class="bg-white p-4 rounded-[2rem] shadow-soft border border-slate-100 max-w-5xl mx-auto">
                <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-2 justify-center lg:justify-start w-full lg:w-auto">
                        <a href="{{ route('posts.index') }}"
                            class="px-6 py-3 rounded-full {{ !request('category') ? 'bg-secondary text-white shadow-lg shadow-blue-900/20' : 'bg-slate-50 text-slate-500 hover:bg-blue-50 hover:text-primary hover:border-blue-100' }} font-bold text-sm transition-all border border-transparent">Todos</a>
                        <a href="{{ route('posts.index', ['category' => 'Artigos']) }}"
                            class="px-6 py-3 rounded-full {{ request('category') == 'Artigos' ? 'bg-secondary text-white shadow-lg shadow-blue-900/20' : 'bg-slate-50 text-slate-500 hover:bg-blue-50 hover:text-primary hover:border-blue-100' }} font-bold text-sm transition-all border border-transparent">Artigos</a>
                        <a href="{{ route('posts.index', ['category' => 'Notícias']) }}"
                            class="px-6 py-3 rounded-full {{ request('category') == 'Notícias' ? 'bg-secondary text-white shadow-lg shadow-blue-900/20' : 'bg-slate-50 text-slate-500 hover:bg-blue-50 hover:text-primary hover:border-blue-100' }} font-bold text-sm transition-all border border-transparent">Notícias</a>
                        <a href="{{ route('posts.index', ['category' => 'Informativos']) }}"
                            class="px-6 py-3 rounded-full {{ request('category') == 'Informativos' ? 'bg-secondary text-white shadow-lg shadow-blue-900/20' : 'bg-slate-50 text-slate-500 hover:bg-blue-50 hover:text-primary hover:border-blue-100' }} font-bold text-sm transition-all border border-transparent">Informativos</a>
                        <a href="{{ route('posts.index', ['category' => 'Eventos']) }}"
                            class="px-6 py-3 rounded-full {{ request('category') == 'Eventos' ? 'bg-secondary text-white shadow-lg shadow-blue-900/20' : 'bg-slate-50 text-slate-500 hover:bg-blue-50 hover:text-primary hover:border-blue-100' }} font-bold text-sm transition-all border border-transparent">Eventos</a>
                    </div>
                    <div class="relative w-full lg:w-80">
                        <form action="{{ route('posts.index') }}" method="GET">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined">search</span>
                            <input name="search" value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 rounded-full border-slate-200 bg-slate-50 focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm font-medium placeholder:text-gray-400" placeholder="Buscar publicação..." type="text">
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Grid -->
        <section class="container mx-auto px-6 mb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article
                        class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-hover border border-slate-100 transition-all duration-300 group flex flex-col h-full hover:-translate-y-1">
                        <div class="relative h-60 rounded-[1.5rem] overflow-hidden mb-5">
                            <img alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                src="{{ $post->image_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBmw_ZFpf2CDj0pVHvRoYRrApxj0TcKAsZwwX9QZToLUqHQhDc7F2qAKdTiFdy_75qvML0ruYT4zIGDNi-ao4GJb1j3QlGX9tB1ryIKiHgCGcBFaLjtDjb3R1m6fb7oynfnDuo-TloDuHX-xNM9AQkn4dgzzEUoZMXRZ6gcsjiZGXd4C9CF3Es7iwj3gixlf5mOOj4O_QAdWYMR_my-CrhTwZqz9VVkBd9crWK-9crzKCUb0z6Uu1gGXFIhPEiM80eVXtZVSX2w-RM' }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-60"></div>
                            <div
                                class="absolute top-4 left-4 bg-white/95 backdrop-blur text-secondary text-xs font-bold px-3 py-1.5 rounded-full shadow-md uppercase tracking-wide border border-slate-100">
                                {{ $post->category }}
                            </div>
                        </div>
                        <div class="px-2 pb-4 flex flex-col flex-1">
                            <div
                                class="flex items-center gap-2 text-primary text-xs font-bold mb-3 uppercase tracking-wider">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $post->published_at->format('d M, Y') }}
                            </div>
                            <h3
                                class="text-xl font-heading font-bold text-secondary mb-3 leading-snug group-hover:text-primary transition-colors">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-slate-500 text-sm mb-6 line-clamp-3 leading-relaxed flex-1">
                                {{ $post->excerpt }}
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-50">
                                <a class="inline-flex items-center gap-2 text-secondary hover:text-accent font-bold text-sm group-hover:gap-3 transition-all"
                                    href="{{ route('posts.show', $post->slug) }}">
                                    Ler artigo completo <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <!-- Pagination -->
        <section class="container mx-auto px-6 pb-12">
            <div
                class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500 font-medium mb-4 md:mb-0">
                    Mostrando <span
                        class="font-bold text-secondary">{{ $posts->firstItem() }}-{{ $posts->lastItem() }}</span> de
                    <span class="font-bold text-secondary">{{ $posts->total() }}</span> resultados
                </p>
                <div class="flex items-center gap-2">
                    {{ $posts->withQueryString()->links('pagination::tailwind') }}
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>