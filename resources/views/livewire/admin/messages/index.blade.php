<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-headings font-bold text-secondary">Mensagens de Contato</h1>
        <p class="text-slate-500 text-sm">Mensagens enviadas pelo formulário público de contato.</p>
    </div>

    <div class="space-y-4">
        @forelse($messages as $msg)
            <div
                class="bg-white rounded-2xl shadow-sm border {{ $msg->is_read ? 'border-slate-100' : 'border-primary/30 bg-primary/5' }} p-5">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-secondary">{{ $msg->name }}</span>
                            @unless($msg->is_read)
                                <span
                                    class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Nova</span>
                            @endunless
                        </div>
                        <div class="text-xs text-slate-400">
                            <a href="mailto:{{ $msg->email }}" class="hover:text-primary">{{ $msg->email }}</a>
                            &middot; {{ $msg->created_at->translatedFormat('d \d\e F \d\e Y, H:i') }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button wire:click="toggleRead({{ $msg->id }})"
                            class="text-slate-400 hover:text-primary transition-colors"
                            title="{{ $msg->is_read ? 'Marcar como não lida' : 'Marcar como lida' }}">
                            <span
                                class="material-symbols-outlined text-lg">{{ $msg->is_read ? 'mark_email_unread' : 'mark_email_read' }}</span>
                        </button>
                        @php
                            $replyFrom = \App\Models\SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com');
                            $replyFirstName = $msg->name ? \Illuminate\Support\Str::of($msg->name)->trim()->explode(' ')->first() : '';
                            $replyBody = "Olá {$replyFirstName},\n\nRecebemos sua mensagem e agradecemos o contato.\n\n\nAtenciosamente,\nEquipe SOPAPE";
                            $replyUrl = 'https://mail.google.com/mail/?authuser='.urlencode($replyFrom)
                                .'&view=cm&fs=1'
                                .'&to='.urlencode($msg->email)
                                .'&su='.urlencode('Re: '.($msg->subject ?: 'sua mensagem'))
                                .'&body='.urlencode($replyBody);
                        @endphp
                        <a href="{{ $replyUrl }}" target="_blank" rel="noopener noreferrer"
                            class="text-blue-400 hover:text-blue-600 transition-colors"
                            title="Responder pelo Gmail ({{ $replyFrom }})">
                            <span class="material-symbols-outlined text-lg">reply</span>
                        </a>
                        <button wire:confirm="Excluir esta mensagem?" wire:click="delete({{ $msg->id }})"
                            class="text-red-400 hover:text-red-600 transition-colors" title="Excluir">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
                @if($msg->subject)
                    <div class="mt-3 text-sm font-bold text-slate-600">{{ $msg->subject }}</div>
                @endif
                <p class="mt-2 text-sm text-slate-600 whitespace-pre-line">{{ $msg->message }}</p>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 py-16 text-center text-slate-400 italic">
                Nenhuma mensagem recebida ainda.
            </div>
        @endforelse
    </div>

    <div>{{ $messages->links() }}</div>
</div>
