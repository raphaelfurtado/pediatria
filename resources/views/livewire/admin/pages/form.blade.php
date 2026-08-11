<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">{{ $pageId ? 'Editar Página' : 'Nova Página' }}</h1>
        <a href="{{ route('admin.pages.index') }}"
            class="text-slate-500 hover:text-secondary font-bold text-sm flex items-center gap-1">
            <span class="material-symbols-outlined">arrow_back</span> Voltar
        </a>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Título</label>
                    <input wire:model.live.debounce.500ms="title" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary">
                    @error('title') <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Slug (URL)</label>
                    <div class="flex gap-2">
                        <input wire:model="slug" type="text" readonly
                            class="flex-1 bg-slate-100 border-slate-200 rounded-lg text-slate-500 cursor-not-allowed">
                        <button type="button" wire:click="regenerateSlug"
                            class="px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center"
                            title="Regenerar a partir do título">
                            <span class="material-symbols-outlined text-base">autorenew</span>
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Endereço final: <span class="font-mono">{{ url('/'.($slug ?: 'slug')) }}</span></p>
                    @error('slug') <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                </div>

                <div wire:ignore x-data="{
                        content: @entangle('content'),
                        isUploading: false,
                        init() {
                            if (this.content && $refs.trix.editor) {
                                $refs.trix.editor.loadHTML(this.content);
                            }
                        },
                        uploadAttachment(attachment) {
                            this.isUploading = true;
                            const file = attachment.file;
                            const form = new FormData();
                            form.append('file', file);
                            fetch('{{ route('admin.upload') }}', {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                                body: form
                            })
                            .then(response => response.json())
                            .then(data => { attachment.setAttributes({ url: data.url, href: data.url }); this.isUploading = false; })
                            .catch(error => { console.error('Error uploading image:', error); this.isUploading = false; });
                        }
                    }" x-on:trix-change="content = $event.target.value"
                    x-on:trix-attachment-add="uploadAttachment($event.attachment)" class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Conteúdo</label>
                    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
                    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
                    <style>
                        trix-editor.trix-content { line-height: 1.6; color: #334155; }
                        trix-editor.trix-content ul { list-style-type: disc !important; margin-left: 1.5rem !important; padding-left: 0.5rem !important; }
                        trix-editor.trix-content ol { list-style-type: decimal !important; margin-left: 1.5rem !important; padding-left: 0.5rem !important; }
                        trix-editor.trix-content blockquote { border-left: 4px solid #FFB703 !important; padding-left: 1rem !important; color: #64748B !important; font-style: italic !important; margin: 1rem 0 !important; background-color: #FFFBEB !important; }
                        trix-editor.trix-content h1 { font-size: 1.5rem; font-weight: 800; color: #023E8A; }
                        trix-toolbar .trix-button--icon-attach { display: inline-block !important; }
                    </style>
                    <input id="content" type="hidden" name="content" x-model="content">
                    <trix-editor x-ref="trix" input="content"
                        class="trix-content min-h-[400px] rounded-lg border-slate-200 focus:border-primary focus:ring-primary bg-white px-4 py-2"></trix-editor>
                    @error('content') <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-4">
                <h3 class="font-bold text-secondary">Publicação</h3>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    <span class="ms-3 text-sm font-bold text-slate-700">Página ativa (visível no site)</span>
                </label>

                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <button type="submit"
                        class="w-full bg-primary hover:bg-primaryLight text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span> Salvar
                    </button>
                    <button type="button" wire:click="save(true)"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        Salvar e voltar à lista
                    </button>
                    @if($pageId)
                        <a href="{{ route('pages.dynamic', $slug) }}" target="_blank"
                            class="w-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">visibility</span> Ver página
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
