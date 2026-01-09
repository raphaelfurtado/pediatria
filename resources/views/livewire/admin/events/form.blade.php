<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">{{ $eventId ? 'Editar Evento' : 'Novo Evento' }}
            </h1>
            <p class="text-slate-500 text-sm">Preencha as informações para o calendário de eventos.</p>
        </div>
        <a href="{{ route('admin.events.index') }}"
            class="text-slate-500 hover:text-secondary flex items-center gap-1 font-bold text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span> Voltar
        </a>
    </div>

    <form wire:submit="save" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Título</label>
                    <input wire:model.live="title" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('title') border-red-500 @enderror"
                        placeholder="Nome do evento">
                    @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Slug</label>
                    <input wire:model="slug" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('slug') border-red-500 @enderror"
                        placeholder="slug-do-evento">
                    @error('slug') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Descrição</label>
                    <textarea wire:model="description" rows="4"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Detalhes sobre o evento"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Data de Início</label>
                    <input wire:model="date_start" type="datetime-local"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('date_start') border-red-500 @enderror">
                    @error('date_start') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Data de Término (Opcional)</label>
                    <input wire:model="date_end" type="datetime-local"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Local</label>
                    <input wire:model="location" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('location') border-red-500 @enderror"
                        placeholder="Ex: Auditório SOPAPE ou Plataforma Online">
                    @error('location') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Link de Inscrição (Opcional)</label>
                    <input wire:model="registration_link" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="https://...">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Tipo de Evento</label>
                    <select wire:model="type"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
                        <option value="presencial">Presencial</option>
                        <option value="online">Online</option>
                        <option value="hibrido">Híbrido</option>
                    </select>
                </div>

                <div class="space-y-2 flex flex-col justify-end pb-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                        </div>
                        <span class="ms-3 text-sm font-bold text-slate-700">Evento em Destaque</span>
                    </label>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Imagem de Capa</label>
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
                                <img src="{{ $existingImage }}"
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
                Salvar Evento
            </button>
        </div>
    </form>
</div>