<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gestão de Menu</h1>
        <a href="{{ route('admin.navigation.create') }}"
            class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span> Novo Item
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6">
            <p class="text-slate-500 mb-6 italic">Arraste para reordenar (Simulação: Ordem manual via ID/Botão por
                enquanto)</p>

            <div class="space-y-4">
                @foreach($menuItems as $item)
                    <div class="border border-slate-100 rounded-xl p-4 bg-slate-50/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-slate-300">drag_indicator</span>
                                <div>
                                    <div class="font-bold text-secondary flex items-center gap-2">
                                        {{ $item->label }}
                                        @if(!$item->is_active)
                                            <span
                                                class="text-[10px] bg-red-100 text-red-500 px-2 py-0.5 rounded-full uppercase font-bold">Inativo</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $item->url ?: '#' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button wire:click="toggleStatus({{ $item->id }})"
                                    class="{{ $item->is_active ? 'text-primary' : 'text-slate-300' }} hover:text-accent transition-colors"
                                    title="{{ $item->is_active ? 'Desativar' : 'Ativar' }}">
                                    <span
                                        class="material-symbols-outlined">{{ $item->is_active ? 'visibility' : 'visibility_off' }}</span>
                                </button>
                                <a href="{{ route('admin.navigation.edit', $item->id) }}"
                                    class="text-blue-400 hover:text-blue-600 transition-colors">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <button wire:confirm="Tem certeza? Isso excluirá também os submenus."
                                    wire:click="delete({{ $item->id }})"
                                    class="text-red-400 hover:text-red-600 transition-colors">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </div>

                        <!-- Children -->
                        @if($item->children->count() > 0)
                            <div class="ml-12 mt-4 space-y-2 border-l-2 border-slate-100 pl-4">
                                @foreach($item->children as $child)
                                    <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-slate-50">
                                        <div class="flex items-center gap-3">
                                            <div class="font-medium text-slate-600 truncate max-w-[200px]">{{ $child->label }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono truncate max-w-[150px]">
                                                {{ $child->url ?: '#' }}</div>
                                            @if(!$child->is_active)
                                                <span
                                                    class="text-[8px] bg-red-100 text-red-500 px-1.5 py-0.5 rounded-full uppercase font-bold">Inativo</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.navigation.edit', $child->id) }}"
                                                class="text-blue-300 hover:text-blue-500 transition-colors scale-75">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <button wire:click="delete({{ $child->id }})"
                                                class="text-red-300 hover:text-red-500 transition-colors scale-75">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($menuItems->isEmpty())
                <div class="py-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-100 mb-4 block">account_tree</span>
                    <p class="text-slate-400 font-medium italic">Nenhum item de menu configurado.</p>
                </div>
            @endif
        </div>
    </div>
</div>