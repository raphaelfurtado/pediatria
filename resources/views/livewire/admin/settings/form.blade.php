<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Configurações do Site</h1>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Social Media -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-secondary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">share</span> Redes Sociais
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Facebook (URL)</label>
                        <input wire:model="facebook" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="https://facebook.com/...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Instagram (URL)</label>
                        <input wire:model="instagram" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="https://instagram.com/...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Twitter / X (URL)</label>
                        <input wire:model="twitter" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="https://twitter.com/...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp (Link ou Número)</label>
                        <input wire:model="whatsapp" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="https://wa.me/...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketing Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-secondary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">campaign</span> Marketing Sidebar (Blog)
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Título do Card</label>
                        <input wire:model="marketing_title" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Descrição / Texto</label>
                        <textarea wire:model="marketing_description" rows="3"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Texto do Botão</label>
                        <input wire:model="marketing_button_text" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Link do Botão</label>
                        <input wire:model="marketing_button_link" type="text"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-primary hover:bg-primaryLight text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span> Atualizar Configurações
                </button>
            </div>
        </div>
    </form>
</div>