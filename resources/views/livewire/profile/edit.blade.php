<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-headings font-bold text-secondary">Meu Perfil</h1>
        <p class="text-slate-500 text-sm">Atualize seus dados e sua senha de acesso.</p>
    </div>

    <form wire:submit="updateProfile" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-5">
        <h2 class="font-bold text-secondary flex items-center gap-2">
            <span class="material-symbols-outlined">badge</span> Meus Dados
        </h2>
        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700">Nome</label>
            <input wire:model="name" type="text"
                class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
            @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700">E-mail</label>
            <input wire:model="email" type="email"
                class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-2.5 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <span wire:loading wire:target="updateProfile"
                    class="animate-spin material-symbols-outlined text-lg">sync</span>
                Salvar dados
            </button>
        </div>
    </form>

    <form wire:submit="updatePassword" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-5">
        <h2 class="font-bold text-secondary flex items-center gap-2">
            <span class="material-symbols-outlined">lock</span> Alterar Senha
        </h2>
        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700">Senha atual</label>
            <x-password-input wire:model="current_password" autocomplete="current-password"
                class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('current_password') border-red-500 @enderror" />
            @error('current_password') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Nova senha</label>
                <x-password-input wire:model="password" autocomplete="new-password"
                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror" />
                @error('password') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Confirmar nova senha</label>
                <x-password-input wire:model="password_confirmation" autocomplete="new-password"
                    class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary" />
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit"
                class="bg-primary hover:bg-secondary text-white font-bold py-2.5 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <span wire:loading wire:target="updatePassword"
                    class="animate-spin material-symbols-outlined text-lg">sync</span>
                Alterar senha
            </button>
        </div>
    </form>
</div>
