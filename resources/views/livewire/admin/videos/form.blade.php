<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">{{ $videoId ? 'Editar Vídeo' : 'Novo Vídeo' }}
            </h1>
            <p class="text-slate-500 text-sm">Cole o link de um vídeo do YouTube ou Vimeo.</p>
        </div>
        <a href="{{ route('admin.videos.index') }}"
            class="text-slate-500 hover:text-secondary flex items-center gap-1 font-bold text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span> Voltar
        </a>
    </div>

    <form wire:submit="save" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Título do Vídeo</label>
                    <input wire:model="title" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('title') border-red-500 @enderror"
                        placeholder="Ex: Dra. Explica - Cuidados com recém nascido">
                    @error('title') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Link do vídeo (YouTube ou Vimeo)</label>
                    <input wire:model.live.debounce.500ms="video_link" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('video_link') border-red-500 @enderror"
                        placeholder="Ex: https://www.youtube.com/watch?v=... ou https://vimeo.com/...">
                    <p class="text-xs text-slate-400">Cole o endereço completo do vídeo. Funciona com
                        <b>youtube.com</b>, <b>youtu.be</b> e <b>vimeo.com</b>. O sistema detecta e incorpora sozinho.</p>
                    @error('video_link') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Descrição (Opcional)</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Breve descrição do conteúdo do vídeo"></textarea>
                </div>

                <div class="space-y-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                        <span class="ms-3 text-sm font-bold text-slate-700">Vídeo Ativo</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                        </div>
                        <span class="ms-3 text-sm font-bold text-slate-700">Destaque na Home</span>
                    </label>
                </div>
            </div>

            @if($this->previewEmbedUrl)
                <div class="pt-6 border-t border-slate-50">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-4">Preview
                        ({{ $previewProvider === 'vimeo' ? 'Vimeo' : 'YouTube' }})</span>
                    <div
                        class="aspect-video w-full max-w-xl mx-auto rounded-3xl overflow-hidden shadow-2xl bg-black border border-slate-100">
                        <iframe class="w-full h-full" src="{{ $this->previewEmbedUrl }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
            @endif
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <button type="button" onclick="history.back()"
                class="px-6 py-2.5 rounded-full font-bold text-slate-500 hover:bg-slate-200 transition-all text-sm">Cancelar</button>
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-2.5 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <span wire:loading wire:target="save" class="animate-spin material-symbols-outlined text-lg">sync</span>
                Salvar Vídeo
            </button>
        </div>
    </form>
</div>