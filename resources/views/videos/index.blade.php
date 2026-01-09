<x-layouts.app title="Galeria de Vídeos">
    <main class="min-h-screen pb-20">
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-blue-50 to-surface-light pt-12 pb-20 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full blob-bg opacity-40 pointer-events-none"></div>
            <div class="container mx-auto px-6 relative z-10 text-center">
                <span class="text-primary font-bold uppercase tracking-widest text-xs mb-3 block animate-fade-in">Canal
                    SOPAPE</span>
                <h1 class="font-heading text-4xl md:text-5xl font-extrabold text-secondary mb-6 leading-tight">
                    Nossos <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Vídeos</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium max-w-2xl mx-auto">
                    Acompanhe palestras, entrevistas, dicas de saúde e treinamentos produzidos pela Sociedade Paraense
                    de Pediatria.
                </p>
            </div>
        </section>

        <!-- Grid -->
        <section class="container mx-auto px-6 -mt-10 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($videos as $video)
                    <article
                        class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-hover border border-slate-100 transition-all duration-300 group flex flex-col hover:-translate-y-1">
                        <div class="relative aspect-video rounded-[1.5rem] overflow-hidden mb-5">
                            @php
                                // Extract Video ID from URL if it's a YouTube link
                                $videoId = '';
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->video_url, $matches)) {
                                    $videoId = $matches[1];
                                }
                                $thumb = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : 'https://via.placeholder.com/800x450';
                            @endphp
                            <img alt="{{ $video->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                src="{{ $thumb }}">
                            <div
                                class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/20 transition-colors">
                                <div
                                    class="w-16 h-16 bg-accent text-secondary rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl font-bold fill-1">play_arrow</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 flex flex-col flex-1">
                            <h3
                                class="text-xl font-heading font-bold text-secondary mb-3 leading-snug group-hover:text-primary transition-colors">
                                {{ $video->title }}
                            </h3>
                            @if($video->description)
                                <p class="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed flex-1">
                                    {{ $video->description }}
                                </p>
                            @endif
                            <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                                <span
                                    class="text-xs text-slate-400 font-medium">{{ $video->created_at->format('d/m/Y') }}</span>
                                @php
                                    $vUrl = $video->video_url;
                                    if ($vUrl && !Str::startsWith($vUrl, ['http://', 'https://', '/'])) {
                                        $vUrl = 'http://' . $vUrl;
                                    }
                                @endphp
                                <a href="{{ $vUrl }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-secondary hover:text-accent font-bold text-sm group-hover:gap-3 transition-all">
                                    Assistir no YouTube <span class="material-symbols-outlined text-lg">open_in_new</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">smart_display</span>
                        <p class="text-slate-400 font-medium italic">Nenhum vídeo encontrado no momento.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $videos->links() }}
            </div>
        </section>
    </main>
</x-layouts.app>