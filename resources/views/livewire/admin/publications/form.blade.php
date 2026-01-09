<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">
                {{ $publicationId ? 'Editar Publicação' : 'Nova Publicação' }}</h1>
            <p class="text-slate-500 text-sm">Gerencie livros, manuais e guias da biblioteca.</p>
        </div>
        <a href="{{ route('admin.publications.index') }}"
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
                        placeholder="Título da publicação">
                    @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Slug</label>
                    <input wire:model="slug" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('slug') border-red-500 @enderror"
                        placeholder="slug-da-publicacao">
                    @error('slug') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Descrição (Opcional)</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Breve resumo da publicação"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Tipo</label>
                    <select wire:model="type"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
                        <option value="livro">Livro</option>
                        <option value="manual">Manual</option>
                        <option value="guia">Guia Prático</option>
                        <option value="revista">Revista</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Ano de Publicação</label>
                    <input wire:model="year" type="number" min="1900" max="{{ date('Y') + 1 }}"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="Ex: 2024">
                </div>

                <div class="space-y-2 col-span-2">
                    <label class="text-sm font-bold text-slate-700">Link Externo (Opcional)</label>
                    <input wire:model="external_link" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                        placeholder="https://...">
                    <p class="text-[10px] text-slate-400 mt-1 italic">Use se o arquivo estiver hospedado em outro site.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-50">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Capa do Livro</label>
                    <div class="flex flex-col gap-4">
                        <div
                            class="relative border-2 border-dashed border-slate-200 rounded-3xl p-6 hover:border-primary transition-colors text-center group">
                            <input type="file" wire:model="cover"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="space-y-2">
                                <span
                                    class="material-symbols-outlined text-2xl text-slate-300 group-hover:text-primary transition-colors">image</span>
                                <div class="text-xs text-slate-500">
                                    <span class="font-bold text-primary">Upload Capa</span><br>
                                    PNG, JPG (Max. 2MB)
                                </div>
                            </div>
                        </div>
                        @if($cover)
                            <img src="{{ $cover->temporaryUrl() }}"
                                class="w-24 h-32 object-cover rounded-lg shadow-md border border-slate-100 mx-auto">
                        @elseif($existingCover)
                            <img src="{{ $existingCover }}"
                                class="w-24 h-32 object-cover rounded-lg shadow-md border border-slate-100 mx-auto">
                        @endif
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Arquivo PDF/Doc</label>
                    <div class="flex flex-col gap-4">
                        <div
                            class="relative border-2 border-dashed border-slate-200 rounded-3xl p-6 hover:border-primary transition-colors text-center group">
                            <input type="file" wire:model="file"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="space-y-2">
                                <span
                                    class="material-symbols-outlined text-2xl text-slate-300 group-hover:text-primary transition-colors">picture_as_pdf</span>
                                <div class="text-xs text-slate-500">
                                    <span class="font-bold text-primary">Upload Arquivo</span><br>
                                    PDF (Max. 10MB)
                                </div>
                            </div>
                        </div>
                        @if($file)
                            <div class="p-3 bg-green-50 rounded-xl flex items-center gap-2 border border-green-100">
                                <span class="material-symbols-outlined text-green-500">check_circle</span>
                                <div class="text-[10px] font-bold text-green-700 truncate">
                                    {{ $file->getClientOriginalName() }}</div>
                            </div>
                        @elseif($existingFile)
                            <div class="p-3 bg-blue-50 rounded-xl flex items-center gap-2 border border-blue-100">
                                <span class="material-symbols-outlined text-blue-500">file_present</span>
                                <div class="text-[10px] font-bold text-blue-700 truncate italic">Arquivo existente</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @error('cover') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span> @enderror
            @error('file') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span> @enderror
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <button type="button" onclick="history.back()"
                class="px-6 py-2.5 rounded-full font-bold text-slate-500 hover:bg-slate-200 transition-all text-sm">Cancelar</button>
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-2.5 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <span wire:loading wire:target="save" class="animate-spin material-symbols-outlined text-lg">sync</span>
                Salvar Publicação
            </button>
        </div>
    </form>
</div>