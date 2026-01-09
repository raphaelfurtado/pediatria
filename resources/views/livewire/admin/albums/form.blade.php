<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">{{ $albumId ? 'Editar Álbum' : 'Novo Álbum' }}
            </h1>
            <p class="text-slate-500 text-sm">Organize as fotos em álbuns temáticos.</p>
        </div>
        <a href="{{ route('admin.albums.index') }}"
            class="text-slate-500 hover:text-secondary flex items-center gap-1 font-bold text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span> Voltar
        </a>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Basic Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Título do Álbum</label>
                        <input wire:model.live="title" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('title') border-red-500 @enderror"
                            placeholder="Ex: Congresso Paraense de Pediatria 2024">
                        @error('title') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Slug</label>
                        <input wire:model="slug" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('slug') border-red-500 @enderror"
                            placeholder="slug-do-album">
                        @error('slug') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Descrição (Opcional)</label>
                        <textarea wire:model="description" rows="3"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                            placeholder="Breve descrição sobre o evento ou álbum"></textarea>
                    </div>

                    <div class="pt-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                            <span class="ms-3 text-sm font-bold text-slate-700">Álbum Ativo</span>
                        </label>
                    </div>
                </div>

                <!-- Multiple Photos Upload -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-secondary">Fotos do Álbum</h2>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ count($photos) }}
                            novas fotos selecionadas</span>
                    </div>

                    <div
                        class="relative border-2 border-dashed border-slate-200 rounded-3xl p-10 hover:border-primary transition-colors text-center group bg-slate-50/50">
                        <input type="file" wire:model="photos" multiple
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-4">
                            <span
                                class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-primary transition-colors">add_a_photo</span>
                            <div class="text-sm text-slate-500">
                                <span class="font-bold text-primary">Clique para adicionar fotos</span> ou arraste
                                aqui<br>
                                <span class="text-xs">JPG ou PNG (Max. 5MB por foto)</span>
                            </div>
                        </div>
                    </div>

                    @if($photos)
                        <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                            @foreach($photos as $index => $photo)
                                <div
                                    class="relative aspect-square rounded-xl overflow-hidden shadow-sm border border-slate-200 animate-fade-in">
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/20"></div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($existingPhotos)
                        <div class="pt-6 border-t border-slate-100">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Fotos Existentes
                            </h3>
                            <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                                @foreach($existingPhotos as $photo)
                                    <div
                                        class="relative aspect-square rounded-xl overflow-hidden shadow-sm border border-slate-200 group/photo">
                                        <img src="{{ $photo->image_path }}" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover/photo:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" wire:click="deletePhoto({{ $photo->id }})"
                                                wire:confirm="Excluir esta foto?"
                                                class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Info (Cover) -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-6 sticky top-6">
                    <label class="text-sm font-bold text-slate-700">Capa do Álbum</label>
                    <div
                        class="relative aspect-[3/4] border-2 border-dashed border-slate-200 rounded-3xl overflow-hidden hover:border-primary transition-colors group cursor-pointer">
                        <input type="file" wire:model="cover"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        @if($cover)
                            <img src="{{ $cover->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                        @elseif($existingCover)
                            <img src="{{ $existingCover }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center space-y-2 text-slate-300 group-hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-4xl">image</span>
                                <span class="text-xs font-bold">Upload Capa</span>
                            </div>
                        @endif
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        </div>
                    </div>
                    @error('cover') <span class="text-red-500 text-xs font-bold italic">{{ $message }}</span> @enderror

                    <div class="pt-4 space-y-3">
                        <button type="submit"
                            class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                            <span wire:loading wire:target="save"
                                class="animate-spin material-symbols-outlined text-lg">sync</span>
                            Salvar Álbum
                        </button>
                        <button type="button" onclick="history.back()"
                            class="w-full bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold py-3 px-8 rounded-2xl transition-all text-sm text-center">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>