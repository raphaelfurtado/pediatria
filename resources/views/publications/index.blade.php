<x-layouts.app title="Biblioteca">
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Publicações e Documentos
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Acesse o acervo técnico e científico da Sociedade.
                </p>
            </div>

            @foreach($publications as $type => $items)
                <div class="mb-16">
                    <h3 class="text-2xl font-bold text-sopape-blue mb-6 border-b border-gray-200 pb-2 capitalize">
                        {{ $type }}s
                    </h3>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($items as $pub)
                            <div
                                class="group relative bg-gray-50 rounded-lg p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100">
                                <div class="aspect-w-3 aspect-h-4 bg-gray-200 rounded-lg overflow-hidden mb-4 relative">
                                    @if($pub->cover_image)
                                        <img src="{{ $pub->cover_image }}" alt="{{ $pub->title }}"
                                            class="object-cover w-full h-full group-hover:opacity-75">
                                    @else
                                        <div class="flex items-center justify-center h-48 bg-gray-100 text-gray-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 group-hover:text-sopape-blue">{{ $pub->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $pub->year }}</p>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $pub->description }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('publications.show', $pub->slug) }}"
                                        class="text-sm font-medium text-sopape-blue group-hover:underline">
                                        Acessar Documento &rarr;
                                    </a>
                                </div>
                                <a href="{{ route('publications.show', $pub->slug) }}"
                                    class="absolute inset-0 focus:outline-none"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>