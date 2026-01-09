<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Galeria de Fotos</h1>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar álbum..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.albums.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span> Novo Álbum
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($albums as $album)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 group flex flex-col">
                <div class="aspect-[4/3] relative overflow-hidden">
                    <img src="{{ $album->cover_image ?? 'https://via.placeholder.com/400x300?text=Sem+Capa' }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-secondary/20 group-hover:bg-secondary/40 transition-colors"></div>
                    <div
                        class="absolute bottom-2 right-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold text-secondary shadow-sm">
                        {{ $album->photos_count }} fotos
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                    <h3 class="font-bold text-slate-700 line-clamp-2 h-10">{{ $album->title }}</h3>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                        <span
                            class="text-[10px] font-bold uppercase tracking-wider {{ $album->is_active ? 'text-green-500' : 'text-slate-400' }}">
                            {{ $album->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.albums.edit', $album->id) }}"
                                class="text-blue-400 hover:text-blue-600 transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </a>
                            <button wire:confirm="Excluir álbum e TODAS as fotos?" wire:click="delete({{ $album->id }})"
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
        {{ $albums->links() }}
    </div>
</div>