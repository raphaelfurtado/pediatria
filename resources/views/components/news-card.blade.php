@props(['post', 'featured' => false])

@if($featured)
    <div
        class="col-span-1 md:col-span-2 row-span-2 relative group overflow-hidden rounded-2xl shadow-lg h-full min-h-[400px]">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
            style="background-image: url('{{ $post->image_path ?? 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
        <div class="absolute bottom-0 left-0 p-8 w-full">
            <span
                class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-white uppercase bg-sopape-yellow rounded-full text-sopape-blue">
                {{ $post->category }}
            </span>
            <h3 class="text-3xl font-bold text-white mb-2 leading-tight">
                <a href="#" class="hover:underline">{{ $post->title }}</a>
            </h3>
            <p class="text-gray-200 mb-4 line-clamp-2 text-sm">{{ $post->excerpt }}</p>
            <div class="flex items-center text-gray-300 text-sm">
                <span>{{ $post->published_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
@else
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
        <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                src="{{ $post->image_path ?? 'https://images.unsplash.com/photo-1576091160550-2187d80aeff2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}"
                alt="{{ $post->title }}">
            <div class="absolute top-4 left-4">
                <span class="px-2 py-1 text-xs font-bold text-white bg-sopape-blue rounded shadow">
                    {{ $post->category }}
                </span>
            </div>
        </div>
        <div class="p-6 flex-1 flex flex-col">
            <div class="text-xs text-gray-500 mb-2">{{ $post->published_at->format('d/m/Y') }}</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight flex-1">
                <a href="#" class="hover:text-sopape-blue transition">{{ $post->title }}</a>
            </h3>
            <a href="#"
                class="mt-4 inline-flex items-center text-sm font-semibold text-sopape-blue hover:text-sopape-yellow transition">
                Ler mais
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
@endif