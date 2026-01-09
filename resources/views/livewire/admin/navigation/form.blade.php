<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.navigation.index') }}"
            class="w-10 h-10 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary transition-colors shadow-sm">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-headings font-bold text-secondary">
            {{ $itemId ? 'Editar Item' : 'Novo Item de Menu' }}
        </h1>
    </div>

    <form wire:submit="save" class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Rótulo (Texto do Menu)</label>
                <input wire:model="label" type="text"
                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all @error('label') border-red-500 @enderror"
                    placeholder="Ex: Home, Institucional...">
                @error('label') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">URL ou Rota</label>
                <input wire:model="url" type="text"
                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all"
                    placeholder="Ex: /contato ou http://google.com">
                <span class="text-[10px] text-slate-400 mt-1 block px-2 italic">Deixe em branco se for apenas um título
                    para submenus.</span>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Item Pai (Para criar submenus)</label>
                <select wire:model="parent_id"
                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
                    <option value="">Nenhum (Item de Topo)</option>
                    @foreach($parentItems as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ordem</label>
                    <input wire:model="order" type="number"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
                </div>
                <div class="flex flex-col justify-end">
                    <label
                        class="flex items-center gap-3 cursor-pointer group p-3 bg-slate-50 rounded-2xl border border-slate-200 hover:border-primary transition-all">
                        <input wire:model="is_active" type="checkbox"
                            class="w-5 h-5 rounded text-primary focus:ring-primary">
                        <span class="text-sm font-bold text-slate-700">Ativo</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-50">
            <a href="{{ route('admin.navigation.index') }}"
                class="px-6 py-3 text-slate-400 font-bold hover:text-slate-600 transition-colors">Cancelar</a>
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-3 px-10 rounded-full shadow-lg transition-all hover:-translate-y-0.5">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>