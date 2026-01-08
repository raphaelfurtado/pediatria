<x-layouts.app>
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Área do Sócio
            </h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500">
                    Sair
                </button>
            </form>
        </div>
    </div>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div
                class="border-4 border-dashed border-gray-200 rounded-lg h-96 flex flex-col justify-center items-center">
                <p class="text-2xl text-gray-500 mb-4">Bem-vindo, {{ $user->name }}!</p>
                <p class="text-gray-400">Esta é a área restrita para sócios e editores.</p>
                <span class="mt-4 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                    Perfil: {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>
    </main>
</x-layouts.app>