<x-layouts.app :title="$post->title">
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
                                    {{ $post->published_at->format('d de F, Y') }}
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
                    <div class="mb-10 rounded-2xl overflow-hidden shadow-sm">
                        <img class="w-full object-cover"
                            src="{{ $post->image_path ?? 'https://images.unsplash.com/photo-1581056771107-24ca5f033842?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                            alt="{{ $post->title }}">
                    </div>

                    <!-- Article Content -->
                    <div class="prose prose-lg prose-blue max-w-none text-gray-600 leading-relaxed">
                        <p class="lead text-xl text-gray-800 font-medium mb-8">
                            {{ $post->excerpt }}
                        </p>

                        {!! $post->content !!}

                    </div>

                    <style>
                        /* Robust Content Styling for News */
                        .prose {
                            color: #334155;
                            /* slate-700 */
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

                    <!-- Share -->
                    <div class="mt-8 pt-8 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-900">Compartilhe este artigo:</span>
                        <div class="flex space-x-3">
                            @if($fb = \App\Models\SiteSetting::get('facebook'))
                                <a href="{{ $fb }}" target="_blank"
                                    class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                            @endif
                            @if($tw = \App\Models\SiteSetting::get('twitter'))
                                <a href="{{ $tw }}" target="_blank"
                                    class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.165-2.724 10.025 10.025 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                </a>
                            @endif
                            @if($wa = \App\Models\SiteSetting::get('whatsapp'))
                                <a href="{{ $wa }}" target="_blank"
                                    class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition">
                                    <span class="sr-only">WhatsApp</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-12 flex justify-between border-t border-gray-100 pt-8">
                        @if($prev = $post->getPrevious())
                            <a href="{{ route('posts.show', $prev->slug) }}"
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
                            <a href="{{ route('posts.show', $next->slug) }}"
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
                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                            src="{{ $rel->image_path ?? 'https://via.placeholder.com/150' }}"
                                            alt="{{ $rel->title }}">
                                    </div>
                                    <div class="ml-4">
                                        <span
                                            class="text-[10px] font-bold text-sopape-blue uppercase">{{ $rel->category }}</span>
                                        <h5
                                            class="text-sm font-bold text-gray-800 leading-snug group-hover:text-sopape-blue transition mb-1 line-clamp-2">
                                            <a href="{{ route('posts.show', $rel->slug) }}">{{ $rel->title }}</a>
                                        </h5>
                                        <span
                                            class="text-xs text-gray-400">{{ $rel->published_at->format('d M, Y') }}</span>
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

                    <!-- Newsletter Widget -->
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
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>