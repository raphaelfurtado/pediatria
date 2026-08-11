<x-layouts.app description="Sociedade Paraense de Pediatria (SOPAPE): notícias, eventos, publicações e defesa da saúde da criança e do adolescente no Pará.">
    <!-- Hero Section -->
    <x-hero :slides="$slides" />

    <!-- Services Cards -->
    <section class="relative z-20 pb-16 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $themes = [
                        'primary' => ['icon' => 'bg-primary text-white shadow-primary/20', 'corner' => 'bg-blue-50', 'link' => 'text-primary'],
                        'accent' => ['icon' => 'bg-accent text-secondary shadow-accent/20', 'corner' => 'bg-yellow-50', 'link' => 'text-tertiary'],
                        'rose' => ['icon' => 'bg-rose text-white shadow-rose/20', 'corner' => 'bg-red-50', 'link' => 'text-rose'],
                        'success' => ['icon' => 'bg-success text-white shadow-success/20', 'corner' => 'bg-teal-50', 'link' => 'text-success'],
                    ];
                @endphp
                @foreach($serviceCards as $card)
                    @php $t = $themes[$card->color] ?? $themes['primary']; @endphp
                    <a class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-hover transition-all duration-300 border border-slate-100 hover:-translate-y-2 relative overflow-hidden"
                        href="{{ $card->link ?: '#' }}">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 {{ $t['corner'] }} rounded-bl-[4rem] -mr-4 -mt-4 transition-transform group-hover:scale-110">
                        </div>
                        <div class="relative z-10">
                            <div
                                class="w-14 h-14 {{ $t['icon'] }} rounded-2xl flex items-center justify-center mb-6 shadow-md group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl">{{ $card->icon }}</span>
                            </div>
                            <h3 class="text-xl font-heading font-bold text-secondary mb-2">{{ $card->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4 font-medium">{{ $card->description }}</p>
                            @if($card->cta_text)
                                <span
                                    class="text-xs font-bold {{ $t['link'] }} uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">{{ $card->cta_text }}
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                            @endif
                        </div>
                    </a>
                @endforeach
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
                @php $mainPost = $featuredPost ?? ($latestPosts->isNotEmpty() ? $latestPosts->shift() : null); @endphp
                @if($mainPost)
                    <article
                        class="relative lg:col-span-1 bg-white rounded-3xl shadow-lg hover:shadow-hover border border-slate-100 overflow-hidden group cursor-pointer flex flex-col h-full">
                        <div class="relative h-64 lg:h-1/2 overflow-hidden">
                            <x-content-image :src="$mainPost->image_path" :alt="$mainPost->title"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-tertiary text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $mainPost->category }}</span>
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="text-gray-400 text-xs font-bold mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $mainPost->published_at->translatedFormat('d M, Y') }}
                            </div>
                            <h3
                                class="text-2xl font-heading font-bold text-secondary mb-4 leading-tight group-hover:text-primary transition-colors">
                                {{ $mainPost->title }}
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1">
                                {{ $mainPost->excerpt }}
                            </p>
                            <span
                                class="text-tertiary font-bold text-sm inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                                {{ $mainPost->isExternal() ? 'Acessar matéria' : 'Ler artigo' }}
                                <span class="material-symbols-outlined">{{ $mainPost->isExternal() ? 'open_in_new' : 'arrow_right_alt' }}</span>
                            </span>
                        </div>
                        <a href="{{ $mainPost->link() }}"
                            @if($mainPost->isExternal()) target="_blank" rel="noopener noreferrer" @endif
                            class="absolute inset-0 z-10" aria-label="{{ $mainPost->title }}"></a>
                    </article>
                @endif

                <!-- Smaller News & CTA (Right) -->
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($latestPosts as $post)
                        <article
                            class="relative bg-white rounded-3xl shadow-md hover:shadow-lg border border-slate-100 p-6 group cursor-pointer">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="relative w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0">
                                    <x-content-image :src="$post->image_path" :alt="$post->title" :label="false"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform" />
                                </div>
                                <div>
                                    <span
                                        class="text-xs font-bold text-success uppercase mb-1 block">{{ $post->category }}</span>
                                    <span class="text-xs text-gray-400">{{ $post->published_at->translatedFormat('d M, Y') }}</span>
                                </div>
                            </div>
                            <h4
                                class="font-heading font-bold text-secondary text-lg leading-snug mb-3 group-hover:text-primary transition-colors flex items-center gap-1">
                                {{ $post->title }}
                                @if($post->isExternal())
                                    <span class="material-symbols-outlined text-sm text-slate-300">open_in_new</span>
                                @endif
                            </h4>
                            <p class="text-gray-500 text-sm line-clamp-2">
                                {{ Str::limit($post->excerpt, 80) }}
                            </p>
                            <a href="{{ $post->link() }}"
                                @if($post->isExternal()) target="_blank" rel="noopener noreferrer" @endif
                                class="absolute inset-0 z-10" aria-label="{{ $post->title }}"></a>
                        </article>
                    @endforeach

                    <!-- CTA Box -->
                    @if(\App\Models\SiteSetting::get('article_cta_enabled', '1') !== '0')
                        <article
                            class="md:col-span-2 bg-gradient-to-br from-secondary to-blue-900 rounded-3xl p-8 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16">
                            </div>
                            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div>
                                    <div class="flex items-center gap-2 text-accent text-xs font-bold uppercase mb-2">
                                        <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                                        {{ \App\Models\SiteSetting::get('article_cta_label', 'Oportunidade') }}
                                    </div>
                                    <h3 class="text-2xl font-bold text-white mb-2">
                                        {{ \App\Models\SiteSetting::get('article_cta_title', 'Quer publicar seu artigo?') }}
                                    </h3>
                                    <p class="text-blue-200 text-sm max-w-md">
                                        {{ \App\Models\SiteSetting::get('article_cta_description', 'A Revista SOPAPE está com edital aberto para submissão de artigos científicos.') }}
                                    </p>
                                </div>
                                <a href="{{ \App\Models\SiteSetting::get('article_cta_button_link', '#') ?: '#' }}"
                                    class="bg-white text-secondary hover:bg-accent hover:text-secondary font-bold py-3 px-6 rounded-full shadow-lg transition-colors flex-shrink-0 text-center whitespace-nowrap">
                                    {{ \App\Models\SiteSetting::get('article_cta_button_text', 'Submeter Artigo') }}
                                </a>
                            </div>
                        </article>
                    @endif
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
                            <x-content-image :src="$event->image_path" :alt="$event->title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <div
                                class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl border border-white/50 text-center shadow-lg">
                                <span
                                    class="block text-2xl font-bold text-primary">{{ $event->date_start->format('d') }}</span>
                                <span
                                    class="block text-xs uppercase font-bold text-slate-500">{{ $event->date_start->translatedFormat('M') }}</span>
                            </div>
                            @if($event->is_featured)
                                <div
                                    class="absolute top-4 right-4 bg-accent text-secondary text-xs font-bold px-3 py-1 rounded-full shadow">
                                    Destaque
                                </div>
                            @endif
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

    <!-- Featured Videos Section -->
    @if($featuredVideos->isNotEmpty())
        <section class="py-16 bg-surface-light border-t border-slate-100">
            <div class="container mx-auto px-6">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <span class="text-primary font-bold uppercase tracking-widest text-xs mb-2 block">Canal SOPAPE</span>
                        <h2 class="text-3xl md:text-4xl font-heading font-extrabold text-secondary">Vídeos em Destaque</h2>
                    </div>
                    <a class="hidden md:flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-primary transition-colors bg-gray-50 px-4 py-2 rounded-full hover:bg-blue-50"
                        href="{{ route('videos.index') }}">
                        Ver todos os vídeos <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredVideos as $video)
                        <article
                            class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-hover border border-slate-100 transition-all duration-300 group flex flex-col hover:-translate-y-1">
                            <a href="{{ $video->watchUrl() }}" target="_blank"
                                rel="noopener noreferrer"
                                class="relative aspect-video rounded-[1.5rem] overflow-hidden mb-5 block bg-secondary/10">
                                @if($video->thumbUrl())
                                    <img alt="{{ $video->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                        src="{{ $video->thumbUrl() }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-secondary to-primary">
                                        <span class="material-symbols-outlined text-white/80 text-6xl">smart_display</span>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/20 transition-colors">
                                    <div
                                        class="w-16 h-16 bg-accent text-secondary rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-3xl font-bold fill-1">play_arrow</span>
                                    </div>
                                </div>
                            </a>
                            <div class="px-2 flex flex-col flex-1">
                                <h3
                                    class="text-lg font-heading font-bold text-secondary mb-2 leading-snug group-hover:text-primary transition-colors line-clamp-2">
                                    {{ $video->title }}
                                </h3>
                                @if($video->description)
                                    <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed">{{ $video->description }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

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