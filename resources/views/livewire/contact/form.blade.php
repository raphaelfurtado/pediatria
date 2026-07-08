<div class="min-h-screen bg-surface-light py-16 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-primary font-bold uppercase tracking-widest text-xs mb-2 block">Fale Conosco</span>
            <h1 class="text-3xl md:text-4xl font-heading font-extrabold text-secondary">Contato</h1>
            <p class="mt-3 text-slate-500 max-w-xl mx-auto">Dúvidas, sugestões ou parcerias? Envie sua mensagem —
                respondemos o quanto antes.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-blue-50 text-primary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase">E-mail</div>
                        <div class="text-secondary font-bold break-all">
                            {{ \App\Models\SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com') }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-blue-50 text-primary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined">call</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase">Telefone</div>
                        <div class="text-secondary font-bold">
                            {{ \App\Models\SiteSetting::get('contact_phone', '(91) 99999-9999') }}</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                @if($sent)
                    <div class="text-center py-12">
                        <div
                            class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl">check</span>
                        </div>
                        <h3 class="text-xl font-bold text-secondary mb-2">Mensagem enviada!</h3>
                        <p class="text-slate-500">Obrigado pelo contato. Responderemos em breve.</p>
                        <button wire:click="$set('sent', false)" class="mt-6 text-primary font-bold text-sm">Enviar outra
                            mensagem</button>
                    </div>
                @else
                    <form wire:submit="submit" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nome</label>
                                <input wire:model="name" type="text"
                                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
                                @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">E-mail</label>
                                <input wire:model="email" type="email"
                                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                                @error('email') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Assunto</label>
                            <input wire:model="subject" type="text"
                                class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mensagem</label>
                            <textarea wire:model="message" rows="6"
                                class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('message') border-red-500 @enderror"></textarea>
                            @error('message') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit"
                            class="bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                            <span wire:loading wire:target="submit"
                                class="animate-spin material-symbols-outlined text-lg">sync</span>
                            Enviar mensagem
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
