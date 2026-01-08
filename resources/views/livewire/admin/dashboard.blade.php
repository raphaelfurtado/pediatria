<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-heading font-bold text-secondary">Dashboard</h1>
            <p class="text-slate-500">Bem-vindo ao painel administrativo da SOPAPE.</p>
        </div>
        <div class="text-sm font-bold text-primary bg-primary/10 px-4 py-2 rounded-full">
            {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">group</span>
            </div>
            <div>
                <span class="block text-2xl font-bold text-secondary">{{ \App\Models\User::count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Usuários</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined">article</span>
            </div>
            <div>
                <span class="block text-2xl font-bold text-secondary">{{ \App\Models\Post::count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Notícias</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center">
                <span class="material-symbols-outlined">event</span>
            </div>
            <div>
                <span class="block text-2xl font-bold text-secondary">{{ \App\Models\Event::count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Eventos</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined">library_books</span>
            </div>
            <div>
                <span class="block text-2xl font-bold text-secondary">{{ \App\Models\Publication::count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Publicações</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="font-heading font-bold text-lg text-secondary mb-4">Últimas Notícias</h2>
            <div class="space-y-4">
                @foreach(\App\Models\Post::latest()->take(5)->get() as $post)
                    <div class="flex items-center gap-4 py-2 border-b border-slate-50 last:border-0">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden">
                            @if($post->image_path)
                                <img src="{{ $post->image_path }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400"><span
                                        class="material-symbols-outlined text-sm">image</span></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4
                                class="text-sm font-bold text-slate-700 truncate hover:text-primary transition-colors cursor-pointer">
                                {{ $post->title }}</h4>
                            <span
                                class="text-xs text-slate-400">{{ $post->published_at ? $post->published_at->diffForHumans() : 'Rascunho' }}</span>
                        </div>
                        <span
                            class="text-xs font-bold px-2 py-1 rounded-full {{ $post->published_at ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $post->published_at ? 'Publicado' : 'Rascunho' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="font-heading font-bold text-lg text-secondary mb-4">Próximos Eventos</h2>
            <div class="space-y-4">
                @foreach(\App\Models\Event::upcoming()->take(5)->get() as $event)
                    <div class="flex items-center gap-4 py-2 border-b border-slate-50 last:border-0">
                        <div
                            class="w-12 h-12 rounded-lg bg-blue-50 flex flex-col items-center justify-center text-primary border border-blue-100">
                            <span class="text-xs font-bold uppercase">{{ $event->date_start->format('M') }}</span>
                            <span class="text-lg font-bold leading-none">{{ $event->date_start->format('d') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-700 truncate">{{ $event->title }}</h4>
                            <div class="flex items-center gap-1 text-xs text-slate-400">
                                <span class="material-symbols-outlined text-[10px]">location_on</span>
                                {{ $event->location }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>