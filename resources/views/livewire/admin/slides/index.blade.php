<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Banners (Carrossel)</h1>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar banner..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary w-64">
            <a href="{{ route('admin.slides.create') }}"
                class="bg-primary hover:bg-primaryLight text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span> Novo Banner
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-24">Ordem</th>
                    <th class="px-6 py-4">Banner</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($slides as $slide)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500 font-bold italic">
                            #{{ $slide->order }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ Storage::url($slide->image_path) }}"
                                    class="w-24 h-12 object-cover rounded-lg border border-slate-200 shadow-sm" alt="">
                                <div>
                                    <div class="font-bold text-slate-700">{{ $slide->title }}</div>
                                    <div class="text-xs text-slate-400">{{ $slide->subtitle }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($slide->is_active)
                                <span
                                    class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Ativo
                                </span>
                            @else
                                <span
                                    class="bg-slate-100 text-slate-500 px-2 py-1 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inativo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.slides.edit', $slide->id) }}"
                                    class="text-blue-400 hover:text-blue-600 transition-colors" title="Editar">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <button wire:confirm="Tem certeza?" wire:click="delete({{ $slide->id }})"
                                    class="text-red-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $slides->links() }}
        </div>
    </div>
</div>