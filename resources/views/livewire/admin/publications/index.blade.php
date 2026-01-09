<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Publicações</h1>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar publicação..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.publications.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span> Nova Publicação
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Título</th>
                    <th class="px-6 py-4">Tipo</th>
                    <th class="px-6 py-4">Ano</th>
                    <th class="px-6 py-4">Arquivo/Link</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($publications as $pub)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $pub->cover_image ?? 'https://via.placeholder.com/40x60' }}"
                                    class="w-8 h-12 object-cover rounded shadow-sm">
                                <div class="font-bold text-slate-700">{{ $pub->title }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">{{ $pub->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            {{ $pub->year ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($pub->file_path)
                                <a href="{{ $pub->file_path }}" target="_blank"
                                    class="text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">picture_as_pdf</span> PDF
                                </a>
                            @elseif($pub->external_link)
                                <a href="{{ $pub->external_link }}" target="_blank"
                                    class="text-slate-400 hover:text-primary flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">link</span> Externo
                                </a>
                            @else
                                <span class="text-slate-300 italic">Nenhum</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.publications.edit', $pub->id) }}"
                                    class="text-blue-400 hover:text-blue-600 transition-colors" title="Editar">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button wire:confirm="Tem certeza?" wire:click="delete({{ $pub->id }})"
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
            {{ $publications->links() }}
        </div>
    </div>
</div>