<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">Cards da Home</h1>
            <p class="text-slate-500 text-sm">Blocos de serviços exibidos logo abaixo do banner na página inicial.</p>
        </div>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar card..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.service-cards.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2 whitespace-nowrap">
                <span class="material-symbols-outlined text-lg">add</span> Novo Card
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-20">Ordem</th>
                    <th class="px-6 py-4">Card</th>
                    <th class="px-6 py-4">Link</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($cards as $card)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500 font-bold italic">#{{ $card->order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                                    <span class="material-symbols-outlined">{{ $card->icon }}</span>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-700">{{ $card->title }}</div>
                                    <div class="text-xs text-slate-400 line-clamp-1 max-w-xs">{{ $card->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs font-mono">{{ $card->link ?: '#' }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleStatus({{ $card->id }})" title="Ativar/Desativar">
                                @if($card->is_active)
                                    <span
                                        class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Ativo
                                    </span>
                                @else
                                    <span
                                        class="bg-slate-100 text-slate-500 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inativo
                                    </span>
                                @endif
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.service-cards.edit', $card->id) }}"
                                    class="text-blue-400 hover:text-blue-600 transition-colors" title="Editar">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button wire:confirm="Tem certeza que deseja excluir este card?"
                                    wire:click="delete({{ $card->id }})"
                                    class="text-red-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Nenhum card cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $cards->links() }}
        </div>
    </div>
</div>
