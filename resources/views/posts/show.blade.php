<x-layouts.app :title="$post->title" :description="$post->excerpt" :image="$post->image_path" og-type="article"
    :edit-url="route('admin.posts.edit', $post->id)">
    <x-slot:seoJsonLd>
        @php
            $articleImage = $post->image_path;
            if ($articleImage && ! \Illuminate\Support\Str::startsWith($articleImage, ['http://', 'https://'])) {
                $articleImage = url($articleImage);
            }
            $articleLd = array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'NewsArticle',
                'headline' => $post->title,
                'description' => (string) \Illuminate\Support\Str::of(strip_tags($post->excerpt ?? ''))->squish()->limit(180),
                'image' => $articleImage ?: null,
                'datePublished' => optional($post->published_at)->toIso8601String(),
                'dateModified' => optional($post->updated_at)->toIso8601String(),
                'author' => ['@type' => 'Person', 'name' => $post->author->name ?? 'SOPAPE'],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'SOPAPE — Sociedade Paraense de Pediatria',
                    'logo' => ['@type' => 'ImageObject', 'url' => url('favicon.svg')],
                ],
                'mainEntityOfPage' => url()->current(),
                'articleSection' => $post->category,
            ], fn ($v) => ! is_null($v) && $v !== '');
        @endphp
        <script type="application/ld+json">{!! json_encode($articleLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-slot:seoJsonLd>
    @if($preview ?? false)
        <div class="bg-amber-400 text-amber-950 text-sm font-bold px-4 py-3 text-center flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-lg">visibility</span>
            Modo pré-visualização — esta é a aparência da matéria. Ela
            {{ $post->published_at && $post->published_at->isFuture() ? 'será publicada em '.$post->published_at->translatedFormat('d/m/Y') : 'ainda não está publicada' }}.
        </div>
    @endif
    <div class="bg-gray-50/50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex text-sm font-medium text-gray-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-sopape-blue">Início</a>
                <span class="mx-2">/</span>
                <a href="{{ route('posts.index') }}" class="hover:text-sopape-blue">Notícias</a>
                <span class="mx-2">/</span>
                <span class="text-sopape-blue font-bold">{{ $post->category }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Main Content (Left, 8 cols) -->
                <div class="lg:col-span-8">
                    <!-- Title & Meta -->
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-8">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center mb-8 pb-8 border-b border-gray-100">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=0D8ABC&color=fff"
                                alt="{{ $post->author->name }}">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-bold text-gray-900">Por {{ $post->author->name }}</div>
                            <div class="flex text-xs text-gray-500 mt-0.5 space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ optional($post->published_at)->translatedFormat('d \d\e F, Y') ?? 'Rascunho (sem data)' }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    5 min de leitura
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="relative aspect-video mb-10 rounded-2xl overflow-hidden shadow-sm">
                        <x-content-image :src="$post->image_path" :alt="$post->title"
                            class="w-full h-full object-cover" />
                    </div>

                    <!-- Article Content -->
                    <div class="prose prose-lg prose-blue max-w-none text-gray-600 leading-relaxed">
                        <p class="lead text-xl text-gray-800 font-medium mb-8">
                            {{ $post->excerpt }}
                        </p>

                        {!! $post->content !!}

                    </div>

                    {{-- Compartilhar --}}
                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <x-share-buttons :url="route('posts.show', $post->slug)" :title="$post->title" />
                    </div>

                    <style>
                        /* Robust Content Styling for News */
                        .prose img,
                        .prose video,
                        .prose iframe {
                            max-width: 100%;
                            height: auto;
                        }

                        .prose table,
                        .prose pre {
                            display: block;
                            max-width: 100%;
                            overflow-x: auto;
                        }

                        .prose {
                            overflow-wrap: break-word;
                            color: #334155;
                            /* slate-700 */
                        }

                        /* Links visíveis na matéria (azul + sublinhado) */
                        .prose a {
                            color: #0096C7;
                            text-decoration: underline;
                            font-weight: 600;
                        }

                        .prose a:hover {
                            color: #023E8A;
                        }

                        /* 1. Enhanced Blockquote (Yellow Card Style) */
                        .prose blockquote {
                            background-color: #FFFBEB;
                            /* Amber-50 */
                            border-left: 6px solid #FFB703;
                            /* sopape-yellow */
                            padding: 2.5rem;
                            border-radius: 1.5rem;
                            font-style: normal;
                            position: relative;
                            margin: 3rem 0;
                            box-shadow: 0 10px 15px -3px rgba(255, 183, 3, 0.1);
                        }

                        .prose blockquote::before {
                            content: 'format_quote';
                            font-family: 'Material Symbols Outlined';
                            position: absolute;
                            top: 1.5rem;
                            left: 1.5rem;
                            font-size: 3rem;
                            color: #FDE68A;
                            /* yellow-200 */
                            opacity: 0.6;
                        }

                        .prose blockquote p {
                            font-weight: 700;
                            color: #0F172A;
                            /* slate-900 */
                            font-size: 1.35rem;
                            line-height: 1.8;
                            margin-bottom: 1rem;
                            position: relative;
                            z-index: 10;
                        }

                        .prose blockquote cite,
                        .prose blockquote footer {
                            display: block;
                            font-size: 1rem;
                            color: #64748B;
                            /* slate-500 */
                            font-weight: 600;
                            margin-top: 1.5rem;
                            font-style: normal;
                        }

                        .prose blockquote cite::before {
                            content: "— ";
                        }

                        /* 2. List items with Checkmarks (Bullet Lists) */
                        .prose ul {
                            list-style-type: none;
                            padding-left: 0;
                        }

                        .prose ul li {
                            position: relative;
                            padding-left: 2.5rem;
                            margin-bottom: 1rem;
                            font-weight: 500;
                        }

                        .prose ul li::before {
                            content: 'check_circle';
                            font-family: 'Material Symbols Outlined';
                            position: absolute;
                            left: 0;
                            top: 0.1rem;
                            color: #22C55E;
                            /* green-500 */
                            font-size: 1.4rem;
                            font-variation-settings: 'FILL' 1;
                        }

                        /* 3. Numbered Lists with Premium Styling */
                        .prose ol {
                            counter-reset: custom-counter;
                            list-style-type: none;
                            padding-left: 0;
                        }

                        .prose ol li {
                            counter-increment: custom-counter;
                            position: relative;
                            padding-left: 3rem;
                            margin-bottom: 1.5rem;
                            font-weight: 500;
                        }

                        .prose ol li::before {
                            content: counter(custom-counter);
                            position: absolute;
                            left: 0;
                            top: -0.1rem;
                            width: 2rem;
                            height: 2rem;
                            background: linear-gradient(135deg, #023E8A, #0096C7);
                            color: white;
                            border-radius: 0.6rem;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 0.875rem;
                            font-weight: 800;
                            box-shadow: 0 4px 6px -1px rgba(2, 62, 138, 0.2);
                        }

                        /* Standard Typography Fixes */
                        .prose h1,
                        .prose h2,
                        .prose h3 {
                            color: #023E8A !important;
                            font-family: 'Poppins', sans-serif !important;
                            font-weight: 800 !important;
                            margin-top: 2.5rem !important;
                            margin-bottom: 1.25rem !important;
                            line-height: 1.3 !important;
                        }

                        .prose h1 {
                            font-size: 2rem !important;
                        }

                        .prose h2 {
                            font-size: 1.75rem !important;
                        }

                        .prose h3 {
                            font-size: 1.5rem !important;
                        }

                        /* Fix for Trix/Prose default spacing */
                        .prose p {
                            margin-top: 1.25rem;
                            margin-bottom: 1.25rem;
                        }

                        /* Remove default Trix/Prose quotes */
                        .prose blockquote p:first-of-type::before {
                            content: none !important;
                        }

                        .prose blockquote p:last-of-type::after {
                            content: none !important;
                        }
                    </style>

                    <!-- Tags -->
                    @if($post->tags)
                        <div class="mt-12 flex flex-wrap gap-2">
                            <span class="text-gray-500 text-sm mr-2 flex items-center hover:bg-transparent">Tags:</span>
                            @foreach($post->tags_array as $tag)
                                <a href="{{ route('posts.index', ['search' => $tag]) }}"
                                    class="px-4 py-1.5 bg-gray-100 rounded-full text-xs font-semibold text-gray-600 hover:bg-gray-200 transition">{{ $tag }}</a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="mt-12 flex justify-between border-t border-gray-100 pt-8">
                        @if($prev = $post->getPrevious())
                            <a href="{{ $prev->link() }}"
                                class="group flex flex-col p-4 rounded-lg hover:bg-white hover:shadow-md transition w-1/2 mr-4 border border-transparent hover:border-gray-100">
                                <span
                                    class="text-xs font-bold text-gray-400 group-hover:text-sopape-blue uppercase tracking-wide mb-1">←
                                    Anterior</span>
                                <span
                                    class="text-sm font-bold text-gray-800 group-hover:text-gray-900">{{ $prev->title }}</span>
                            </a>
                        @else
                            <div class="w-1/2"></div>
                        @endif

                        @if($next = $post->getNext())
                            <a href="{{ $next->link() }}"
                                class="group flex flex-col p-4 rounded-lg hover:bg-white hover:shadow-md transition w-1/2 ml-4 text-right border border-transparent hover:border-gray-100">
                                <span
                                    class="text-xs font-bold text-gray-400 group-hover:text-sopape-blue uppercase tracking-wide mb-1">Próximo
                                    →</span>
                                <span
                                    class="text-sm font-bold text-gray-800 group-hover:text-gray-900">{{ $next->title }}</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Sidebar (Right, 4 cols) -->
                <div class="lg:col-span-4 space-y-8">

                    <!-- Search Widget -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-4">Buscar</h4>
                        <div class="relative">
                            <input type="text" placeholder="Buscar notícia, artigos..."
                                class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sopape-blue focus:bg-white transition text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts Widget -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="font-bold text-gray-900">Postagens Relacionadas</h4>
                            <a href="{{ route('posts.index', ['category' => $post->category]) }}"
                                class="text-xs font-bold text-sopape-blue hover:text-sopape-yellow">Ver tudo</a>
                        </div>
                        <div class="space-y-6">
                            @foreach($relatedPosts as $rel)
                                <div class="flex items-start group">
                                    <div class="relative w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                        <x-content-image :src="$rel->image_path" :alt="$rel->title" :label="false"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300" />
                                    </div>
                                    <div class="ml-4">
                                        <span
                                            class="text-[10px] font-bold text-sopape-blue uppercase">{{ $rel->category }}</span>
                                        <h5
                                            class="text-sm font-bold text-gray-800 leading-snug group-hover:text-sopape-blue transition mb-1 line-clamp-2">
                                            <a href="{{ $rel->link() }}" @if($rel->isExternal()) target="_blank" rel="noopener noreferrer" @endif>{{ $rel->title }}</a>
                                        </h5>
                                        <span
                                            class="text-xs text-gray-400">{{ $rel->published_at->translatedFormat('d M, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-4">Categorias</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categories as $cat)
                                <a href="{{ route('posts.index', ['category' => $cat]) }}"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-xs text-gray-600 rounded-md transition border border-gray-200">{{ $cat }}</a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter Widget (liga/desliga em Configurações → Newsletter) -->
                    @if(\App\Models\SiteSetting::get('marketing_enabled', '0') === '1')
                    <div class="bg-sopape-yellow p-8 rounded-2xl text-center shadow-lg relative overflow-hidden">
                        <div class="relative z-10">
                            <div
                                class="w-12 h-12 bg-black text-sopape-yellow rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">{{ \App\Models\SiteSetting::get('marketing_title', 'Receba novidades') }}</h4>
                            <p class="text-sm text-gray-800 mb-6 opacity-80">{{ \App\Models\SiteSetting::get('marketing_description', 'Inscreva-se para receber atualizações da SOPAPE') }}</p>
                            <a href="{{ \App\Models\SiteSetting::get('marketing_button_link', '#') }}" target="_blank"
                                class="w-full inline-block bg-black text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition">
                                {{ \App\Models\SiteSetting::get('marketing_button_text', 'Inscrever-se') }}
                            </a>
                        </div>
                        <!-- Circle Decor -->
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-white opacity-20 rounded-full"></div>
                        <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-white opacity-20 rounded-full"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>