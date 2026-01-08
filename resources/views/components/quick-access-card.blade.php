@props(['icon', 'title', 'description', 'link' => '#', 'color' => 'text-sopape-blue'])

<div class="bg-white rounded-2xl shadow-xl p-6 transform hover:-translate-y-1 transition duration-300">
    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 mb-4">
        <svg class="w-6 h-6 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            {!! $icon !!}
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-500 text-sm mb-4">{{ $description }}</p>
    <a href="{{ $link }}" class="inline-flex items-center text-sopape-blue font-semibold hover:underline">
        Saiba mais
        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </a>
</div>