@props(['editUrl' => null, 'editLabel' => 'Editar'])

@auth
    @php $barUser = auth()->user(); @endphp
    @if(in_array($barUser->role, ['admin', 'editor']))
        <div x-data="{ show: true }" x-show="show" x-cloak
            class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[90] flex items-center gap-1 bg-secondary text-white rounded-full shadow-2xl px-2 py-1.5 text-sm border border-white/10 max-w-[95vw]">
            <span class="flex items-center gap-2 pl-2 pr-1">
                <span class="w-6 h-6 rounded-full bg-primary flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($barUser->name, 0, 1)) }}
                </span>
                <span class="hidden sm:inline font-bold truncate max-w-[140px]">{{ $barUser->name }}</span>
                <span class="hidden md:inline text-blue-200 text-xs">· {{ ucfirst($barUser->role) }}</span>
            </span>

            @if($editUrl)
                <a href="{{ $editUrl }}"
                    class="flex items-center gap-1 bg-accent text-secondary font-bold px-3 py-1.5 rounded-full hover:bg-white transition-colors">
                    <span class="material-symbols-outlined text-base">edit</span>
                    <span class="whitespace-nowrap">{{ $editLabel }}</span>
                </a>
            @endif

            <a href="{{ route('admin.dashboard') }}" title="Painel"
                class="flex items-center gap-1 hover:bg-white/15 px-3 py-1.5 rounded-full transition-colors">
                <span class="material-symbols-outlined text-base">dashboard</span>
                <span class="hidden sm:inline">Painel</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" title="Sair"
                    class="flex items-center hover:bg-white/15 px-3 py-1.5 rounded-full transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                </button>
            </form>

            <button type="button" @click="show = false" title="Ocultar barra"
                class="w-7 h-7 rounded-full hover:bg-white/15 flex items-center justify-center text-blue-200 flex-shrink-0">
                <span class="material-symbols-outlined text-base">close</span>
            </button>
        </div>
    @endif
@endauth
