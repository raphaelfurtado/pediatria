<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">Registro de Atividades</h1>
            <p class="text-slate-500 text-sm">Histórico de quem criou, editou ou excluiu conteúdo no painel.</p>
        </div>
        <div class="flex gap-3">
            <select wire:model.live="event"
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary">
                <option value="">Todas as ações</option>
                <option value="created">Criações</option>
                <option value="updated">Edições</option>
                <option value="deleted">Exclusões</option>
            </select>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por descrição ou usuário..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Ação</th>
                    <th class="px-6 py-4">Usuário</th>
                    <th class="px-6 py-4">Quando</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($logs as $log)
                    @php
                        $badge = match($log->event) {
                            'created' => ['bg-green-100 text-green-700', 'add_circle'],
                            'updated' => ['bg-blue-100 text-blue-700', 'edit'],
                            'deleted' => ['bg-red-100 text-red-700', 'delete'],
                            'restored' => ['bg-amber-100 text-amber-700', 'restore'],
                            default => ['bg-slate-100 text-slate-600', 'info'],
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center {{ $badge[0] }}">
                                    <span class="material-symbols-outlined text-lg">{{ $badge[1] }}</span>
                                </span>
                                <span class="text-slate-700">{{ $log->description }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $log->user_name }}</td>
                        <td class="px-6 py-4 text-slate-400 text-xs whitespace-nowrap">
                            {{ $log->created_at->translatedFormat('d/m/Y H:i') }}
                            <div class="text-slate-300">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-4xl block mb-2">history</span>
                            Nenhuma atividade registrada ainda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
