<x-layouts.app title="{{ $album->title }}">
    <main class="min-h-screen pb-20">
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-blue-50 to-surface-light pt-12 pb-20 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full blob-bg opacity-40 pointer-events-none"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <a href="{{ route('gallery.index') }}"
                        class="inline-flex items-center gap-2 text-primary font-bold text-sm mb-6 hover:gap-3 transition-all">
                        <span class="material-symbols-outlined text-sm">arrow_back</span> Voltar para galeria
                    </a>
                    <h1 class="font-heading text-4xl md:text-5xl font-extrabold text-secondary mb-4 leading-tight">
                        {{ $album->title }}
                    </h1>
                    @if($album->description)
                        <p class="text-lg text-slate-500 font-medium max-w-2xl mx-auto">{{ $album->description }}</p>
                    @endif
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <span
                            class="bg-white px-4 py-2 rounded-full border border-slate-100 shadow-sm text-sm font-bold text-slate-600 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-sm">calendar_today</span>
                            {{ $album->created_at->format('d \d\e F, Y') }}
                        </span>
                        <span
                            class="bg-white px-4 py-2 rounded-full border border-slate-100 shadow-sm text-sm font-bold text-slate-600 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-sm">photo_library</span>
                            {{ $album->photos->count() }} fotos
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Grid -->
        <section class="container mx-auto px-6 mb-16">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="gallery-container">
                @foreach($album->photos as $photo)
                    <a data-fslightbox="gallery" href="{{ $photo->image_path }}"
                        class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer shadow-sm border border-slate-100 transition-all hover:shadow-hover">
                        <img src="{{ $photo->image_path }}" alt="Photo"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-3xl">zoom_in</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </main>
</x-layouts.app>