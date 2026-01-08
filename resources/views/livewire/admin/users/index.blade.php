<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-headings font-bold text-secondary">Gerenciamento de Usuários</h1>
        <div class="flex gap-2">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nome ou email..."
                class="bg-white border-slate-200 rounded-full px-4 py-2 text-sm focus:ring-primary focus:border-primary">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Usuário</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Função (Role)</th>
                    <th class="px-6 py-4">Data de Cadastro</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $user->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->id === auth()->id())
                                <span class="bg-blue-100 text-blue-700 font-bold text-xs px-2 py-1 rounded-full uppercase">Admin
                                    (Você)</span>
                            @else
                                <select wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                    class="bg-slate-50 border-transparent rounded-lg text-xs font-bold uppercase cursor-pointer focus:ring-primary focus:border-primary py-1 pl-2 pr-6">
                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Sócio</option>
                                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                                <button wire:confirm="Tem certeza que deseja excluir este usuário?"
                                    wire:click="delete({{ $user->id }})"
                                    class="text-red-400 hover:text-red-600 transition-colors">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>