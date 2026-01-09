<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">{{ $slideId ? 'Editar Banner' : 'Novo Banner' }}
            </h1>
            <p class="text-slate-500 text-sm">Preencha as informações para o carrossel da página inicial.</p>
        </div>
        <a href="{{ route('admin.slides.index') }}"
            class="text-slate-500 hover:text-secondary flex items-center gap-1 font-bold text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span> Voltar
        </a>
    </div>

    <form wire:submit="save" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Título</label>
                    <input wire:model="title" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('title') border-red-500 @enderror"
                        placeholder="Título principal do banner">
                    @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Subtítulo (Opcional)</label>
                    <textarea wire:model="subtitle" rows="2"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Breve descrição ou chamada extra"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Texto do Botão</label>
                    <input wire:model="button_text" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Ex: Saiba Mais">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Link do Botão</label>
                    <input wire:model="button_link" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Ex: /noticias/vacinacao">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Ordem</label>
                    <input wire:model="order" type="number"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="0">
                </div>

                <div class="space-y-2 flex flex-col justify-end pb-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                        <span class="ms-3 text-sm font-bold text-slate-700">Banner Ativo</span>
                    </label>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Imagem do Banner</label>
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-full md:w-1/2">
                        <div
                            class="relative border-2 border-dashed border-slate-200 rounded-3xl p-8 hover:border-primary transition-colors text-center group">
                            <input type="file" wire:model="image"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="space-y-4">
                                <span
                                    class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-primary transition-colors">cloud_upload</span>
                                <div class="text-sm text-slate-500">
                                    <span class="font-bold text-primary">Clique para upload</span> ou arraste a
                                    imagem<br>
                                    <span class="text-xs">PNG, JPG ou WEBP (Max. 2MB)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2">
                        @if($image)
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Preview</span>
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-full h-40 object-cover rounded-2xl shadow-lg border border-slate-100">
                            </div>
                        @elseif($existingImage)
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Imagem Atual</span>
                                <img src="{{ Storage::url($existingImage) }}"
                                    class="w-full h-40 object-cover rounded-2xl shadow-lg border border-slate-100">
                            </div>
                        @endif
                    </div>
                </div>
                @error('image') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <button type="button" onclick="history.back()"
                class="px-6 py-2.5 rounded-full font-bold text-slate-500 hover:bg-slate-200 transition-all text-sm">Cancelar</button>
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-2.5 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <span wire:loading wire:target="save" class="animate-spin material-symbols-outlined text-lg">sync</span>
                Salvar Banner
            </button>
        </div>
    </form>
</div>