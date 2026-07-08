<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">Página "Sobre"</h1>
            <p class="text-slate-500 text-sm">Edite o conteúdo exibido em <span class="font-mono">/sobre</span>.</p>
        </div>
        <a href="/sobre" target="_blank"
            class="text-slate-500 hover:text-secondary flex items-center gap-1 font-bold text-sm">
            <span class="material-symbols-outlined text-lg">open_in_new</span> Ver página
        </a>
    </div>

    @if(session('notify'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl text-sm font-bold">
            {{ session('notify') }}
        </div>
    @endif

    <form wire:submit="save" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Título</label>
                    <input wire:model="title" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('title') border-red-500 @enderror">
                    @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Subtítulo</label>
                    <input wire:model="subtitle" type="text"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary">
                </div>
            </div>

            <div wire:ignore x-data="{
                content: @entangle('content'),
                init() {
                    if (this.content && $refs.trix.editor) {
                        $refs.trix.editor.loadHTML(this.content);
                    }
                },
                uploadAttachment(attachment) {
                    const form = new FormData();
                    form.append('file', attachment.file);
                    fetch('{{ route('admin.upload') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                        body: form
                    })
                    .then(r => r.json())
                    .then(data => attachment.setAttributes({ url: data.url, href: data.url }))
                    .catch(e => console.error('Erro no upload:', e));
                }
            }" x-on:trix-change="content = $event.target.value"
                x-on:trix-attachment-add="uploadAttachment($event.attachment)" class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Conteúdo</label>
                <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
                <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
                <style>
                    trix-editor.trix-content {
                        line-height: 1.6;
                        color: #334155;
                    }

                    trix-editor.trix-content ul {
                        list-style-type: disc !important;
                        margin-left: 1.5rem !important;
                    }

                    trix-editor.trix-content ol {
                        list-style-type: decimal !important;
                        margin-left: 1.5rem !important;
                    }

                    trix-editor.trix-content h1 {
                        font-size: 1.5rem;
                        font-weight: 800;
                        color: #023E8A;
                    }
                </style>
                <input id="content" type="hidden" x-model="content">
                <trix-editor x-ref="trix" input="content"
                    class="trix-content min-h-[350px] rounded-lg border-slate-200 focus:border-primary focus:ring-primary bg-white px-4 py-2"></trix-editor>
                @error('content') <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-2.5 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <span wire:loading wire:target="save" class="animate-spin material-symbols-outlined text-lg">sync</span>
                Salvar
            </button>
        </div>
    </form>
</div>
