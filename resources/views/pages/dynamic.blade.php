<x-layouts.app :title="$page->title"
    :description="\Illuminate\Support\Str::of(strip_tags($page->content ?? ''))->squish()->limit(160)"
    :edit-url="route('admin.pages.edit', $page->id)">
    <div class="bg-white py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm font-medium text-gray-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary">Início</a>
                <span class="mx-2">/</span>
                <span class="text-primary font-bold">{{ $page->title }}</span>
            </nav>

            <h1 class="text-3xl md:text-4xl font-extrabold text-secondary mb-8">{{ $page->title }}</h1>

            <div class="prose prose-lg prose-blue max-w-none text-gray-600">
                @if(filled($page->content))
                    {!! $page->content !!}
                @else
                    <p class="italic text-gray-400">Conteúdo em breve.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
