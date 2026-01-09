<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Vídeos</h1>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar vídeo..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.videos.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span> Novo Vídeo
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($videos as $video)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 group">
                <div class="aspect-video relative overflow-hidden">
                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg"
                        class="w-full h-full object-cover">
                    <div
                        class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined text-4xl text-white">play_circle</span>
                    </div>
                    @if($video->is_featured)
                        <div class="absolute top-2 left-2">
                            <span
                                class="bg-accent text-secondary text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Destaque</span>
                        </div>
                    @endif
                </div>
                <div class="p-4 space-y-3">
                    <h3 class="font-bold text-slate-700 line-clamp-1 h-6">{{ $video->title }}</h3>
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[10px] font-bold uppercase tracking-wider {{ $video->is_active ? 'text-green-500' : 'text-slate-400' }}">
                            {{ $video->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.videos.edit', $video->id) }}"
                                class="text-blue-400 hover:text-blue-600 transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </a>
                            <button wire:confirm="Excluir vídeo?" wire:click="delete({{ $video->id }})"
                                class="text-red-400 hover:text-red-600 transition-colors">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $videos->links() }}
    </div>
</div>