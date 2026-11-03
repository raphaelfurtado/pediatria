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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Cópia fora do servidor --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
            <h3 class="font-bold text-secondary flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">forward_to_inbox</span> Cópia por e-mail
            </h3>
            <p class="text-sm text-slate-500">Cada backup (o diário e os manuais) é enviado como anexo para este
                e-mail. Assim existe uma cópia <strong>fora do servidor</strong>, que sobrevive mesmo se a hospedagem
                perder os arquivos. Deixe em branco para desativar.</p>
            <form wire:submit="saveBackupEmail" class="flex flex-col sm:flex-row gap-2">
                <input wire:model="backupEmail" type="email" placeholder="ex.: ti.sopape@gmail.com"
                    class="flex-1 bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary">
                <button type="submit"
                    class="bg-primary hover:bg-secondary text-white font-bold py-2 px-5 rounded-lg transition-colors">Salvar</button>
            </form>
            @error('backupEmail') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            <p class="text-xs text-slate-400 flex gap-1">
                <span class="material-symbols-outlined text-sm">lock</span>
                O backup contém todos os dados do site, inclusive cadastros de usuários. Use um e-mail de acesso
                restrito à diretoria/TI.
            </p>
            @if($backupEmail && ! $mailConfigured)
                <p class="text-xs font-bold text-amber-700">Enquanto o envio de e-mails do servidor não estiver
                    configurado (ao lado), as cópias não serão enviadas.</p>
            @endif
        </div>

        {{-- Diagnóstico de e-mail --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
            <h3 class="font-bold text-secondary flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">mail</span> Envio de e-mails do servidor
            </h3>

            @if($mailConfigured)
                <div class="flex items-center gap-2 rounded-xl bg-green-50 border border-green-100 p-3 text-sm text-green-800">
                    <span class="material-symbols-outlined">check_circle</span>
                    Configurado ({{ strtoupper($mail['mailer']) }}{{ $mail['host'] ? ' · '.$mail['host'].':'.$mail['port'] : '' }}),
                    enviando como {{ $mail['from'] }}.
                </div>
            @else
                <div class="rounded-xl bg-red-50 border border-red-100 p-3 text-sm text-red-800 space-y-2">
                    <p class="flex items-center gap-2 font-bold">
                        <span class="material-symbols-outlined">error</span>
                        Não configurado: e-mails não estão sendo enviados (modo "{{ $mail['mailer'] }}").
                    </p>
                    <p>Por isso não chegam o aviso de nova mensagem de contato, o "esqueci minha senha" e as cópias de
                        backup. Para resolver, no cPanel:</p>
                    <ol class="list-decimal ml-5 space-y-1">
                        <li>Crie uma conta de e-mail, ex.: <code>site@sopape.org.br</code>.</li>
                        <li>Edite o arquivo <code>/pediatria/.env</code>:
                            <code class="block mt-1 whitespace-pre bg-white/70 rounded p-2 text-xs">MAIL_MAILER=smtp
MAIL_HOST=mail.sopape.org.br
MAIL_PORT=465
MAIL_SCHEME=smtps
MAIL_USERNAME=site@sopape.org.br
MAIL_PASSWORD=(senha da conta)
MAIL_FROM_ADDRESS=site@sopape.org.br</code></li>
                        <li>Apague <code>/pediatria/bootstrap/cache/config.php</code>, se existir.</li>
                    </ol>
                </div>
            @endif

            <button wire:click="sendTestEmail" wire:loading.attr="disabled" wire:target="sendTestEmail"
                class="flex items-center gap-2 border border-slate-200 hover:border-primary hover:text-primary text-slate-600 font-bold py-2 px-4 rounded-lg transition-colors disabled:opacity-60">
                <span wire:loading.remove wire:target="sendTestEmail" class="material-symbols-outlined text-lg">send</span>
                <span wire:loading wire:target="sendTestEmail" class="animate-spin material-symbols-outlined text-lg">sync</span>
                Enviar e-mail de teste para {{ auth()->user()->email }}
            </button>

            @if($mailTest)
                <p @class(['text-sm font-bold', 'text-green-700' => $mailTest['ok'], 'text-red-600' => ! $mailTest['ok']])>
                    {{ $mailTest['message'] }}
                </p>
            @endif
        </div>
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
