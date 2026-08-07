<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Notícias</h1>
        <div class="flex flex-wrap items-center gap-3">
            <div class="inline-flex bg-white border border-slate-200 rounded-full p-1">
                <button wire:click="setTrashed(false)"
                    class="px-4 py-1.5 rounded-full text-sm font-bold transition-colors {{ ! $trashed ? 'bg-primary text-white shadow' : 'text-slate-500 hover:text-secondary' }}">
                    Ativas
                </button>
                <button wire:click="setTrashed(true)"
                    class="px-4 py-1.5 rounded-full text-sm font-bold transition-colors flex items-center gap-1 {{ $trashed ? 'bg-primary text-white shadow' : 'text-slate-500 hover:text-secondary' }}">
                    <span class="material-symbols-outlined text-base">delete</span> Lixeira ({{ $trashedCount }})
                </button>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar notícia..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-56">
            @unless($trashed)
                <a href="{{ route('admin.posts.create') }}"
                    class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span> Nova Notícia
                </a>
            @endunless
        </div>
    </div>

    {{-- Barra de ações em lote --}}
    @if(count($selected))
        <div class="bg-secondary text-white rounded-2xl px-5 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <span class="font-bold text-sm flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ count($selected) }} notícia(s) selecionada(s)
            </span>
            <div class="flex gap-2">
                @if($trashed)
                    <button wire:click="restoreSelected"
                        class="bg-white/15 hover:bg-white/25 text-white font-bold text-sm py-2 px-4 rounded-full flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">restore</span> Restaurar
                    </button>
                    <button wire:confirm="Excluir DEFINITIVAMENTE as notícias selecionadas? Não será possível recuperar."
                        wire:click="forceDeleteSelected"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold text-sm py-2 px-4 rounded-full flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">delete_forever</span> Excluir definitivo
                    </button>
                @else
                    <button wire:confirm="Mover as notícias selecionadas para a lixeira?" wire:click="deleteSelected"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold text-sm py-2 px-4 rounded-full flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">delete</span> Excluir selecionadas
                    </button>
                @endif
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-4 py-4 w-10">
                        <input type="checkbox" wire:model.live="selectAll"
                            class="rounded border-slate-300 text-primary focus:ring-primary cursor-pointer">
                    </th>
                    <th class="px-6 py-4">Título</th>
                    <th class="px-6 py-4">Autor</th>
                    <th class="px-6 py-4">Categoria</th>
                    <th class="px-6 py-4">{{ $trashed ? 'Excluída em' : 'Status' }}</th>
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($posts as $post)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-4">
                            <input type="checkbox" wire:model.live="selected" value="{{ $post->id }}"
                                class="rounded border-slate-300 text-primary focus:ring-primary cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 flex items-center gap-2">
                                @if($post->is_featured)
                                    <span class="material-symbols-outlined text-accent text-lg" title="Destaque na Home">star</span>
                                @endif
                                {{ $post->title }}
                            </div>
                            <div class="text-xs text-slate-400 truncate max-w-xs">{{ $post->excerpt }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $post->author->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold">{{ $post->category }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($trashed)
                                <span class="text-slate-400 text-xs">{{ optional($post->deleted_at)->format('d/m/Y H:i') }}</span>
                            @elseif($post->published_at && $post->published_at->isPast())
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Publicado</span>
                            @elseif($post->published_at && $post->published_at->isFuture())
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1"><span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> Agendado</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1"><span class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> Rascunho</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($trashed)
                                    <button wire:click="restore({{ $post->id }})" title="Restaurar"
                                        class="text-green-500 hover:text-green-700 transition-colors">
                                        <span class="material-symbols-outlined text-lg">restore</span>
                                    </button>
                                    <button wire:confirm="Excluir DEFINITIVAMENTE esta notícia? Não será possível recuperar."
                                        wire:click="forceDeleteRow({{ $post->id }})" title="Excluir definitivamente"
                                        class="text-red-400 hover:text-red-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete_forever</span>
                                    </button>
                                @else
                                    @if($post->published_at && $post->published_at->isPast())
                                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                                            class="text-slate-400 hover:text-primary transition-colors" title="Ver matéria">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.posts.preview', $post->id) }}" target="_blank"
                                            class="text-amber-500 hover:text-amber-600 transition-colors" title="Pré-visualizar">
                                            <span class="material-symbols-outlined text-lg">preview</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" title="Editar"
                                        class="text-blue-400 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <button wire:confirm="Mover esta notícia para a lixeira?" wire:click="delete({{ $post->id }})"
                                        title="Excluir" class="text-red-400 hover:text-red-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-4xl block mb-2">{{ $trashed ? 'delete' : 'inbox' }}</span>
                            {{ $trashed ? 'A lixeira está vazia.' : 'Nenhuma notícia encontrada.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $posts->links() }}
        </div>
    </div>
</div>
