<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Redefinir senha</h2>
            <p class="mt-2 text-sm text-gray-600">Escolha uma nova senha para sua conta.</p>
        </div>

        <form class="mt-8 space-y-4" wire:submit="resetPassword">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input wire:model="email" type="email" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue sm:text-sm">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nova senha</label>
                <x-password-input wire:model="password" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue sm:text-sm" />
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar nova senha</label>
                <x-password-input wire:model="password_confirmation" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue sm:text-sm" />
            </div>
            <button type="submit"
                class="w-full flex justify-center items-center py-2 px-4 rounded-md text-white bg-sopape-blue hover:bg-opacity-90 font-medium text-sm mt-2">
                <span wire:loading wire:target="resetPassword"
                    class="animate-spin material-symbols-outlined text-lg mr-2">sync</span>
                Redefinir senha
            </button>
        </form>
    </div>
</div>
