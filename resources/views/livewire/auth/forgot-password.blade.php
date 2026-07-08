<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Recuperar senha</h2>
            <p class="mt-2 text-sm text-gray-600">Informe seu e-mail e enviaremos um link para redefinir a senha.</p>
        </div>

        @if($status)
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-4">{{ $status }}</div>
        @endif

        <form class="mt-8 space-y-6" wire:submit="sendLink">
            <div>
                <label class="sr-only">E-mail</label>
                <input wire:model="email" type="email" required placeholder="Seu e-mail"
                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue sm:text-sm">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="w-full flex justify-center items-center py-2 px-4 rounded-md text-white bg-sopape-blue hover:bg-opacity-90 font-medium text-sm">
                <span wire:loading wire:target="sendLink"
                    class="animate-spin material-symbols-outlined text-lg mr-2">sync</span>
                Enviar link
            </button>
            <p class="text-center text-sm">
                <a href="{{ route('login') }}" class="text-sopape-blue hover:text-sopape-yellow font-medium">Voltar para
                    o login</a>
            </p>
        </form>
    </div>
</div>
