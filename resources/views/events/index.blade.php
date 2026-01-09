<x-layouts.app title="Agenda e Eventos">
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Agenda e Eventos
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Fique por dentro dos congressos, cursos e reuniões da SOPAPE.
                </p>
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-6">Próximos Eventos</h3>
            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3 mb-16">
                @forelse($upcomingEvents as $event)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row transition-shadow hover:shadow-lg">
                        <div
                            class="md:w-1/3 bg-sopape-blue text-white p-6 flex flex-col justify-center items-center text-center">
                            <span class="text-4xl font-bold">{{ $event->date_start->format('d') }}</span>
                            <span class="uppercase font-semibold tracking-wide">{{ $event->date_start->format('M') }}</span>
                            <span class="text-sm opacity-80 mt-1">{{ $event->date_start->format('Y') }}</span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $event->type === 'online' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($event->type) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $event->date_start->format('H:i') }}</span>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h4>
                                <p class="text-gray-600 text-sm mb-4">{{ $event->location }}</p>
                            </div>
                            <div class="mt-4">
                                @php
                                    $regUrl = $event->registration_link;
                                    if ($regUrl && !Str::startsWith($regUrl, ['http://', 'https://', '/'])) {
                                        $regUrl = 'http://' . $regUrl;
                                    }
                                @endphp
                                <a href="{{ $regUrl ?? '#' }}" target="_blank"
                                    class="text-secondary font-bold hover:text-accent transition-colors flex items-center gap-2">
                                    Mais detalhes <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3 text-center">Nenhum evento futuro agendado no momento.</p>
                @endforelse
            </div>

            @if($pastEvents->count() > 0)
                <div class="border-t border-gray-200 pt-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Eventos Realizados</h3>
                    <ul class="divide-y divide-gray-200 bg-white rounded-lg shadow">
                        @foreach($pastEvents as $event)
                            <li class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="text-center mr-6 text-gray-500">
                                            <span class="block font-bold">{{ $event->date_start->format('d/m') }}</span>
                                            <span class="text-xs">{{ $event->date_start->format('Y') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $event->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $event->location }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Concluído
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>