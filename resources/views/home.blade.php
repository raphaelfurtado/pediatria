<x-layouts.app title="Home">
    <!-- Hero Section -->
    <x-hero :slides="$slides" />

    <!-- Services Cards -->
    <section class="relative z-20 pb-16 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-hover transition-all duration-300 border border-slate-100 hover:-translate-y-2 relative overflow-hidden"
                    href="{{ route('register') }}">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[4rem] -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center mb-6 shadow-md shadow-primary/20 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">badge</span>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-secondary mb-2">Seja um Sócio</h3>
                        <p class="text-sm text-gray-500 mb-4 font-medium">Benefícios exclusivos para sua carreira e
                            acesso à comunidade.</p>
                        <span
                            class="text-xs font-bold text-primary uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">Saiba
                            mais <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </div>
                </a>
                <a class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-hover transition-all duration-300 border border-slate-100 hover:-translate-y-2 relative overflow-hidden"
                    href="#">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-yellow-50 rounded-bl-[4rem] -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 bg-accent text-secondary rounded-2xl flex items-center justify-center mb-6 shadow-md shadow-accent/20 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">calendar_month</span>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-secondary mb-2">Calendário Vacinal</h3>
                        <p class="text-sm text-gray-500 mb-4 font-medium">Datas atualizadas para proteger seus pacientes
                            e familiares.</p>
                        <span
                            class="text-xs font-bold text-tertiary uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">Ver
                            calendário <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </div>
                </a>
                <a class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-hover transition-all duration-300 border border-slate-100 hover:-translate-y-2 relative overflow-hidden"
                    href="#">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-bl-[4rem] -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 bg-rose text-white rounded-2xl flex items-center justify-center mb-6 shadow-md shadow-rose/20 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">school</span>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-secondary mb-2">Cursos UNA-SUS</h3>
                        <p class="text-sm text-gray-500 mb-4 font-medium">Educação continuada e cursos online gratuitos
                            disponíveis.</p>
                        <span
                            class="text-xs font-bold text-rose uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">Acessar
                            cursos <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </div>
                </a>
                <a class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-hover transition-all duration-300 border border-slate-100 hover:-translate-y-2 relative overflow-hidden"
                    href="#">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-teal-50 rounded-bl-[4rem] -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 bg-success text-white rounded-2xl flex items-center justify-center mb-6 shadow-md shadow-success/20 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">chat_bubble</span>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-secondary mb-2">Fale com Pediatra</h3>
                        <p class="text-sm text-gray-500 mb-4 font-medium">Canal direto de comunicação para
                            esclarecimento de dúvidas.</p>
                        <span
                            class="text-xs font-bold text-success uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">Iniciar
                            conversa <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-16 bg-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full blob-bg opacity-30 pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span
                        class="text-primary font-bold uppercase tracking-widest text-xs mb-2 block">Atualizações</span>
                    <h2 class="text-3xl md:text-4xl font-heading font-extrabold text-secondary">Notícias & Novidades
                    </h2>
                </div>
                <a class="hidden md:flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-primary transition-colors bg-gray-50 px-4 py-2 rounded-full hover:bg-blue-50"
                    href="{{ route('posts.index') }}">
                    Ver todas as notícias <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Featured News (Left) -->
                @if($latestPosts->isNotEmpty())
                    @php $mainPost = $latestPosts->shift(); @endphp
                    <article
                        class="lg:col-span-1 bg-white rounded-3xl shadow-lg hover:shadow-hover border border-slate-100 overflow-hidden group cursor-pointer flex flex-col h-full">
                        <div class="relative h-64 lg:h-1/2 overflow-hidden">
                            <img alt="{{ $mainPost->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                src="{{ $mainPost->image_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBmw_ZFpf2CDj0pVHvRoYRrApxj0TcKAsZwwX9QZToLUqHQhDc7F2qAKdTiFdy_75qvML0ruYT4zIGDNi-ao4GJb1j3QlGX9tB1ryIKiHgCGcBFaLjtDjb3R1m6fb7oynfnDuo-TloDuHX-xNM9AQkn4dgzzEUoZMXRZ6gcsjiZGXd4C9CF3Es7iwj3gixlf5mOOj4O_QAdWYMR_my-CrhTwZqz9VVkBd9crWK-9crzKCUb0z6Uu1gGXFIhPEiM80eVXtZVSX2w-RM' }}">
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-tertiary text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $mainPost->category }}</span>
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="text-gray-400 text-xs font-bold mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $mainPost->published_at->format('d M, Y') }}
                            </div>
                            <h3
                                class="text-2xl font-heading font-bold text-secondary mb-4 leading-tight group-hover:text-primary transition-colors">
                                <a href="{{ route('posts.show', $mainPost->slug) }}">{{ $mainPost->title }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1">
                                {{ $mainPost->excerpt }}
                            </p>
                            <a href="{{ route('posts.show', $mainPost->slug) }}"
                                class="text-tertiary font-bold text-sm inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                                Ler artigo <span class="material-symbols-outlined">arrow_right_alt</span>
                            </a>
                        </div>
                    </article>
                @endif

                <!-- Smaller News & CTA (Right) -->
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($latestPosts as $post)
                        <article
                            class="bg-white rounded-3xl shadow-md hover:shadow-lg border border-slate-100 p-6 group cursor-pointer">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0">
                                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform"
                                        src="{{ $post->image_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAdpI5GzXBkhOzQ_J_ISGV6P24CPBD3MzFYVjAEmDvD-w14JCkzmby_imyVEglgriRlTHJoCZX-Q8VsUBKsGNGZ2FSngLl5KDAfS3kk6Oua2C_LddPLTibmNoHUUia9peB05Zbgt0iadndRi5XCw0l80PwbzIlAQGJvxZMzBNlYqy4FYBJUeotKAO6sbbhIIbUDEF1ytxBxjAVB1agWTRmeDkXbF-I4g2tn6cc2of6qB5BKfgueobSCDK35vJarErdhAQmH-LdYIbY' }}">
                                </div>
                                <div>
                                    <span
                                        class="text-xs font-bold text-success uppercase mb-1 block">{{ $post->category }}</span>
                                    <span class="text-xs text-gray-400">{{ $post->published_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                            <h4
                                class="font-heading font-bold text-secondary text-lg leading-snug mb-3 group-hover:text-primary transition-colors">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h4>
                            <p class="text-gray-500 text-sm line-clamp-2">
                                {{ Str::limit($post->excerpt, 80) }}
                            </p>
                        </article>
                    @endforeach

                    <!-- CTA Box -->
                    <article
                        class="md:col-span-2 bg-gradient-to-br from-secondary to-blue-900 rounded-3xl p-8 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16">
                        </div>
                        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <div class="flex items-center gap-2 text-accent text-xs font-bold uppercase mb-2">
                                    <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span> Oportunidade
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">Quer publicar seu artigo?</h3>
                                <p class="text-blue-200 text-sm max-w-md">
                                    A Revista SOPAPE está com edital aberto para submissão de artigos científicos.
                                </p>
                            </div>
                            <button
                                class="bg-white text-secondary hover:bg-accent hover:text-secondary font-bold py-3 px-6 rounded-full shadow-lg transition-colors flex-shrink-0">
                                Submeter Artigo
                            </button>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Agenda Section -->
    <section class="py-20 bg-surface-light relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-secondary mb-3">Agenda SOPAPE</h2>
                    <p class="text-slate-500 max-w-md font-medium">Participe dos nossos cursos, congressos e encontros.
                    </p>
                </div>
                <div class="flex gap-3">
                    <button
                        class="w-12 h-12 rounded-full bg-white border border-slate-200 shadow-sm flex items-center justify-center text-secondary hover:bg-primary hover:text-white hover:border-primary transition-all">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button
                        class="w-12 h-12 rounded-full bg-white border border-slate-200 shadow-sm flex items-center justify-center text-secondary hover:bg-primary hover:text-white hover:border-primary transition-all">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($upcomingEvents as $event)
                    <div
                        class="group bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-slate-100">
                        <div class="h-52 overflow-hidden relative">
                            <img alt="{{ $event->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                src="{{ $event->image_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCxY3OrFYRKXa4yLpTZRhZJbJ5YjoX4iiQ8lBPEZBnehAH7O5-qmFCummmzCK_eAMtpI5-YIFw_xJBQ02aLb93PMGfnLCb8pQtGRUTkZw6d5k66tOPXJkP4fOIiPhptunptgJmLTlX7izV1JvFE0-jrPNCH-hJz_vkbZy2B6XIif4sQTxK-_Hy_xeyotw7xsR7tSk2LCTc0EQ-EWHBL5JIejoKOQUFJ9gVl3KBRk-BvepvJwLWOzHV0H9l9YAM-S996RnV_OPlT85Q' }}">
                            <div
                                class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl border border-white/50 text-center shadow-lg">
                                <span
                                    class="block text-2xl font-bold text-primary">{{ $event->date_start->format('d') }}</span>
                                <span
                                    class="block text-xs uppercase font-bold text-slate-500">{{ $event->date_start->format('M') }}</span>
                            </div>
                            <div
                                class="absolute bottom-4 right-4 bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full">
                                {{ ucfirst($event->type) }}
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase mb-3">
                                <span class="material-symbols-outlined text-sm">location_on</span> {{ $event->location }}
                            </div>
                            <h3
                                class="text-xl font-bold text-secondary mb-3 leading-tight group-hover:text-primary transition-colors">
                                {{ $event->title }}
                            </h3>
                            <a class="inline-flex items-center text-sm font-bold text-primary hover:text-secondary transition-colors mt-2"
                                href="{{ $event->registration_link ?? route('events.index') }}" target="_blank">
                                Inscreva-se <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @endforeach

                <div
                    class="group bg-accent rounded-3xl overflow-hidden p-8 flex flex-col justify-center items-center text-center relative shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div
                        class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-6 text-secondary backdrop-blur-sm">
                        <span class="material-symbols-outlined text-4xl">calendar_month</span>
                    </div>
                    <h3 class="text-2xl font-bold text-secondary mb-2">Calendário Completo</h3>
                    <p class="text-secondary/80 text-sm mb-8 font-medium">Não perca nenhum evento. Confira a programação
                        anual.</p>
                    <a class="bg-secondary text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-white hover:text-secondary transition-colors w-full"
                        href="{{ route('events.index') }}">
                        Ver Agenda
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Publications Section -->
    @if($publications->isNotEmpty())
        <section class="py-16 bg-white border-t border-slate-100">
            <div class="container mx-auto px-6 text-center">
                <span class="text-primary font-bold uppercase tracking-widest text-xs mb-2 block">Biblioteca</span>
                <h2 class="text-3xl font-heading font-extrabold text-secondary mb-4">Publicações em Destaque</h2>
                <p class="text-gray-500 mb-12 max-w-2xl mx-auto">Livros, manuais e guias essenciais para o dia a dia do
                    pediatra e para a orientação de famílias.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
                    @foreach($publications as $pub)
                        <div class="group cursor-pointer">
                            <a href="{{ route('publications.show', $pub->slug) }}">
                                <div
                                    class="relative w-3/4 mx-auto aspect-[3/4] transition-all duration-300 transform group-hover:-translate-y-3 group-hover:shadow-2xl shadow-lg rounded-lg overflow-hidden">
                                    <img alt="{{ $pub->title }}" class="w-full h-full object-cover"
                                        src="{{ $pub->cover_image ?? 'https://via.placeholder.com/300x400?text=SOPAPE' }}">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                                </div>
                                <h4 class="mt-5 font-bold text-secondary text-base group-hover:text-primary transition-colors">
                                    {{ $pub->title }}
                                </h4>
                                <span
                                    class="text-xs font-bold text-gray-400 uppercase tracking-wide">{{ ucfirst($pub->type) }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>