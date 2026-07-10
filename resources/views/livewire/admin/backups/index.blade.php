<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">Backups do Banco</h1>
            <p class="text-slate-500 text-sm">Cópias de segurança de todo o conteúdo do site (notícias, eventos,
                usuários, configurações).</p>
        </div>
        <button wire:click="createNow" wire:loading.attr="disabled" wire:target="createNow"
            class="bg-primary hover:bg-primaryLight text-white font-bold py-2.5 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-60">
            <span wire:loading.remove wire:target="createNow" class="material-symbols-outlined text-lg">backup</span>
            <span wire:loading wire:target="createNow" class="animate-spin material-symbols-outlined text-lg">sync</span>
            <span wire:loading.remove wire:target="createNow">Fazer backup agora</span>
            <span wire:loading wire:target="createNow">Gerando...</span>
        </button>
    </div>

    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex gap-3 text-sm text-slate-600">
        <span class="material-symbols-outlined text-primary">schedule</span>
        <p>Um backup automático é gerado <strong>todos os dias às 3h</strong> (se o agendador estiver configurado no
            servidor). Os <strong>14 backups mais recentes</strong> são mantidos; os mais antigos são removidos
            automaticamente. Baixe periodicamente uma cópia para o seu computador.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Arquivo</th>
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Tamanho</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($backups as $backup)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs text-slate-600 flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-lg">database</span>
                            {{ $backup['name'] }}
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $backup['created_at']->translatedFormat('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ number_format($backup['size'] / 1024, 1, ',', '.') }} KB</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.backups.download', $backup['name']) }}"
                                    class="text-primary hover:text-secondary transition-colors" title="Baixar">
                                    <span class="material-symbols-outlined text-lg">download</span>
                                </a>
                                <button wire:confirm="Remover este backup?" wire:click="delete('{{ $backup['name'] }}')"
                                    class="text-red-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-4xl block mb-2">inbox</span>
                            Nenhum backup ainda. Clique em "Fazer backup agora" para criar o primeiro.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
