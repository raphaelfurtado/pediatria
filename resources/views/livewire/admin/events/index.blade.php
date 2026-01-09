<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Eventos</h1>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar evento..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.events.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span> Novo Evento
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Evento</th>
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Local</th>
                    <th class="px-6 py-4">Tipo</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($events as $event)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700">{{ $event->title }}</div>
                            @if($event->is_featured)
                                <span
                                    class="bg-accent/20 text-accent text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Destaque</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $event->date_start->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            {{ $event->location }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold uppercase">{{ $event->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.events.edit', $event->id) }}"
                                    class="text-blue-400 hover:text-blue-600 transition-colors" title="Editar">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button wire:confirm="Tem certeza?" wire:click="delete({{ $event->id }})"
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
            {{ $events->links() }}
        </div>
    </div>
</div>