<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Notícias</h1>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar notícia..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.posts.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span> Nova Notícia
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Título</th>
                    <th class="px-6 py-4">Autor</th>
                    <th class="px-6 py-4">Categoria</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($posts as $post)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700">{{ $post->title }}</div>
                            <div class="text-xs text-slate-400 truncate max-w-xs">{{ $post->excerpt }}</div>
                        </td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            <span
                                class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                {{ substr($post->author->name, 0, 1) }}
                            </span>
                            {{ $post->author->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold">{{ $post->category }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->published_at && $post->published_at->isPast())
                                <span
                                    class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Publicado</span>
                            @else
                                <span
                                    class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> Rascunho</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-400 hover:text-blue-600 transition-colors" title="Editar">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button wire:confirm="Tem certeza?" wire:click="delete({{ $post->id }})"
                                    class="text-red-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $posts->links() }}
        </div>
    </div>
</div>