<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">Páginas</h1>
            <p class="text-slate-500 text-sm">Crie páginas institucionais (Diretoria, Estatuto, Missão…) e aponte o menu
                para elas.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}"
            class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span> Nova Página
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Título</th>
                    <th class="px-6 py-4">Endereço</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pages as $page)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $page->title }}</td>
                        <td class="px-6 py-4 text-slate-400 font-mono text-xs">/{{ $page->slug }}</td>
                        <td class="px-6 py-4">
                            @if($page->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">Ativa</span>
                            @else
                                <span class="bg-slate-100 text-slate-500 px-2 py-1 rounded-full text-xs font-bold">Inativa</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="moveUp({{ $page->id }})"
                                    class="text-slate-400 hover:text-primary transition-colors" title="Mover para cima">
                                    <span class="material-symbols-outlined text-lg">keyboard_arrow_up</span>
                                </button>
                                <button wire:click="moveDown({{ $page->id }})"
                                    class="text-slate-400 hover:text-primary transition-colors" title="Mover para baixo">
                                    <span class="material-symbols-outlined text-lg">keyboard_arrow_down</span>
                                </button>
                                <button wire:click="toggleStatus({{ $page->id }})"
                                    class="{{ $page->is_active ? 'text-primary' : 'text-slate-300' }} hover:text-accent transition-colors"
                                    title="{{ $page->is_active ? 'Desativar' : 'Ativar' }}">
                                    <span class="material-symbols-outlined text-lg">{{ $page->is_active ? 'visibility' : 'visibility_off' }}</span>
                                </button>
                                @if($page->is_active)
                                    <a href="{{ route('pages.dynamic', $page->slug) }}" target="_blank"
                                        class="text-slate-400 hover:text-primary transition-colors" title="Ver página">
                                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                                    </a>
                                @endif
                                <a href="{{ route('admin.pages.edit', $page->id) }}"
                                    class="text-blue-400 hover:text-blue-600 transition-colors" title="Editar">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button wire:confirm="Excluir esta página?" wire:click="delete({{ $page->id }})"
                                    class="text-red-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-4xl block mb-2">description</span>
                            Nenhuma página ainda. Clique em "Nova Página".
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex gap-3 text-sm text-slate-600">
        <span class="material-symbols-outlined text-primary">tips_and_updates</span>
        <p>Para exibir uma página no site, vá em <strong>Menu e Navegação</strong> e crie um item (ex.: dentro de
            "Institucional") apontando para <span class="font-mono">/o-slug-da-pagina</span> (ex.: <span
                class="font-mono">/diretoria</span>).</p>
    </div>
</div>
