@props(['event'])

<div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-sopape-blue w-64 flex-shrink-0 mr-6 mb-2">
    <div class="p-5">
        <div class="flex items-start justify-between mb-4">
            <div class="text-center bg-gray-100 rounded-lg p-2 min-w-[60px]">
                <span
                    class="block text-xs font-bold text-gray-500 uppercase">{{ $event->date_start->format('M') }}</span>
                <span class="block text-2xl font-bold text-sopape-blue">{{ $event->date_start->format('d') }}</span>
            </div>
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->type === 'online' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ ucfirst($event->type) }}
            </span>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 h-14" title="{{ $event->title }}">
            {{ $event->title }}
        </h3>
        <div class="flex items-center text-gray-500 text-sm mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="truncate">{{ $event->location }}</span>
        </div>
        <a href="#"
            class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sopape-blue hover:bg-opacity-90">
            Inscrever-se
        </a>
    </div>
</div>