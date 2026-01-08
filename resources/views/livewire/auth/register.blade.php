<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Crie sua conta
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="font-medium text-sopape-blue hover:text-sopape-yellow">
                    Faça login
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" wire:submit.prevent="register">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Nome Completo</label>
                    <input id="name" wire:model="name" name="name" type="text" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue focus:z-10 sm:text-sm"
                        placeholder="Nome Completo">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="email-address" class="sr-only">Email</label>
                    <input id="email-address" wire:model="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue focus:z-10 sm:text-sm"
                        placeholder="Endereço de Email">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="password" class="sr-only">Senha</label>
                    <input id="password" wire:model="password" name="password" type="password" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue focus:z-10 sm:text-sm"
                        placeholder="Senha">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">Confirmar Senha</label>
                    <input id="password_confirmation" wire:model="password_confirmation" name="password_confirmation"
                        type="password" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-sopape-blue focus:border-sopape-blue focus:z-10 sm:text-sm"
                        placeholder="Confirmar Senha">
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sopape-blue hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sopape-blue">
                    Registrar
                </button>
            </div>

            <div wire:loading wire:target="register" class="text-center text-sm text-gray-500">
                Criando conta...
            </div>
        </form>
    </div>
</div>