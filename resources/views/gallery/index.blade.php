<x-layouts.app title="Galeria de Fotos">
    <main class="min-h-screen pb-20">
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-blue-50 to-surface-light pt-12 pb-20 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full blob-bg opacity-40 pointer-events-none"></div>
            <div class="container mx-auto px-6 relative z-10 text-center">
                <span
                    class="text-primary font-bold uppercase tracking-widest text-xs mb-3 block animate-fade-in">Registros
                    SOPAPE</span>
                <h1 class="font-heading text-4xl md:text-5xl font-extrabold text-secondary mb-6 leading-tight">
                    Galeria de <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Fotos</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium max-w-2xl mx-auto">
                    Confira as fotos de nossos congressos, eventos, cursos e momentos especiais da pediatria paraense.
                </p>
            </div>
        </section>

        <!-- Grid -->
        <section class="container mx-auto px-6 -mt-10 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($albums as $album)
                    <a href="{{ route('gallery.show', $album->id) }}"
                        class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-hover border border-slate-100 transition-all duration-300 group flex flex-col hover:-translate-y-1">
                        <div class="relative h-64 rounded-[1.5rem] overflow-hidden mb-5">
                            @php
                                $cover = $album->photos->first()?->image_path ?? 'https://via.placeholder.com/800x600?text=SOPAPE+Galeria';
                            @endphp
                            <img alt="{{ $album->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                src="{{ $cover }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span
                                    class="bg-accent text-secondary text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-widest mb-2 inline-block">
                                    {{ $album->photos_count }} fotos
                                </span>
                                <h3 class="text-white font-bold text-lg leading-tight">{{ $album->title }}</h3>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-2 pb-2">
                            <span
                                class="text-xs text-slate-400 font-medium">{{ $album->created_at->format('d/m/Y') }}</span>
                            <span
                                class="text-primary font-bold text-sm group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                Ver álbum <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">photo_library</span>
                        <p class="text-slate-400 font-medium italic">Nenhum álbum encontrado no momento.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $albums->links() }}
            </div>
        </section>
    </main>
</x-layouts.app>