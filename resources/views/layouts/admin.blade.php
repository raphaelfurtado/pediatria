<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ($title ?? null) ? $title . ' | SOPAPE Admin' : 'Painel · SOPAPE Admin' }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;500;700&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-secondary text-white flex-shrink-0">
            <div class="p-6 flex items-center gap-3 border-b border-white/10">
                <div
                    class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-secondary font-bold shadow-lg">
                    <span class="material-symbols-outlined text-lg">admin_panel_settings</span>
                </div>
                <span class="font-heading font-bold text-lg tracking-wide">SOPAPE Admin</span>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.dashboard') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.manual') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.manual') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">help</span>
                    <span class="font-medium">Manual de Uso</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-bold text-blue-300 uppercase tracking-wider">Site</div>

                <a href="{{ route('admin.slides.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.slides.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">view_carousel</span>
                    <span class="font-medium">Destaques (Home)</span>
                </a>
                <a href="{{ route('admin.service-cards.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.service-cards.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">dashboard_customize</span>
                    <span class="font-medium">Cards da Home</span>
                </a>
                <a href="{{ route('admin.about') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.about') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">info</span>
                    <span class="font-medium">Página Sobre</span>
                </a>
                <a href="{{ route('admin.messages.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.messages.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">forum</span>
                    <span class="font-medium flex-1">Mensagens</span>
                    @php $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadMessages > 0)
                        <span
                            class="bg-accent text-secondary text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadMessages }}</span>
                    @endif
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-bold text-blue-300 uppercase tracking-wider">Conteúdo</div>

                <a href="{{ route('admin.posts.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.posts.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">article</span>
                    <span class="font-medium">Notícias</span>
                </a>
                <a href="{{ route('admin.events.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.events.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">event</span>
                    <span class="font-medium">Eventos</span>
                </a>
                <a href="{{ route('admin.publications.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.publications.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">library_books</span>
                    <span class="font-medium">Publicações</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Central de Mídia</span>
                </div>

                <a href="{{ route('admin.albums.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.albums.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">photo_library</span>
                    <span class="font-medium">Galerias</span>
                </a>
                <a href="{{ route('admin.videos.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.videos.*') ? 'active-nav' : '' }}">
                    <span class="material-symbols-outlined">movie</span>
                    <span class="font-medium">Vídeos</span>
                </a>

                @if(auth()->user()->role === 'admin')
                    <div class="pt-4 pb-2 px-4 text-xs font-bold text-blue-300 uppercase tracking-wider">Sistema</div>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.users.index') ? 'active-nav' : '' }}">
                        <span class="material-symbols-outlined">group</span>
                        <span class="font-medium">Usuários</span>
                    </a>
                    <a href="{{ route('admin.navigation.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.navigation.*') ? 'active-nav' : '' }}">
                        <span class="material-symbols-outlined">menu_open</span>
                        <span class="font-medium">Menu e Navegação</span>
                    </a>
                    <a href="{{ route('admin.settings') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.settings') ? 'active-nav' : '' }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span class="font-medium">Configurações</span>
                    </a>
                    <a href="{{ route('admin.activities.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.activities.*') ? 'active-nav' : '' }}">
                        <span class="material-symbols-outlined">history</span>
                        <span class="font-medium">Atividades</span>
                    </a>
                    <a href="{{ route('admin.backups.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-colors {{ request()->routeIs('admin.backups.*') ? 'active-nav' : '' }}">
                        <span class="material-symbols-outlined">backup</span>
                        <span class="font-medium">Backups</span>
                    </a>
                @endif
            </nav>

            <div class="mt-auto p-4 border-t border-white/10 w-full bg-secondary">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div
                        class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-sm font-bold truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-blue-300 truncate">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
                <a href="{{ route('admin.profile') }}"
                    class="w-full flex items-center justify-center gap-2 bg-white/5 hover:bg-white/20 text-white py-2 rounded-lg transition-colors text-sm font-bold mb-2 {{ request()->routeIs('admin.profile') ? 'bg-white/20' : '' }}">
                    <span class="material-symbols-outlined text-sm">manage_accounts</span> Meu Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white py-2 rounded-lg transition-colors text-sm font-bold">
                        <span class="material-symbols-outlined text-sm">logout</span> Sair do Painel
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-slate-50">
            <!-- Topbar (Mobile) -->
            <div class="md:hidden bg-white p-4 shadow-sm flex items-center justify-between">
                <span class="font-bold text-secondary">Painel Administrativo</span>
                <button class="text-slate-500"><span class="material-symbols-outlined">menu</span></button>
            </div>

            <div class="container mx-auto px-6 py-8">
                <x-admin.route-help />
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    <div x-data="{ 
        show: false, 
        message: '',
        color: 'bg-green-600',
        init() {
            @if(session()->has('notify'))
                this.showToast('{{ session('notify') }}', 'bg-green-600');
            @endif
            window.addEventListener('notify', event => {
                this.showToast(event.detail[0] || event.detail, 'bg-green-600');
            });
        },
        showToast(msg, clr) {
            this.message = msg;
            this.color = clr;
            this.show = true;
            setTimeout(() => { this.show = false }, 3000);
        }
    }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed bottom-6 right-6 z-50 px-6 py-3 rounded-xl shadow-2xl text-white font-bold flex items-center gap-3"
        :class="color" style="display: none;">
        <span class="material-symbols-outlined">check_circle</span>
        <span x-text="message"></span>
    </div>

    {{-- Aparência de link dentro do editor + diálogo do Trix visível --}}
    <style>
        trix-editor.trix-content a {
            color: #0096C7;
            text-decoration: underline;
            font-weight: 600;
        }
        trix-toolbar .trix-dialog {
            background: #ffffff;
            padding: 10px;
            box-shadow: 0 10px 25px -10px rgba(2, 62, 138, .35);
            border-radius: 10px;
        }
        trix-toolbar .trix-input--dialog {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 14px;
        }
        trix-toolbar .trix-button-group--dialog {
            margin-top: 6px;
        }
        [x-cloak] { display: none !important; }

        /* Cursor de "mãozinha" em elementos clicáveis */
        button:not(:disabled),
        [role="button"],
        summary,
        select,
        label:has(> input[type="checkbox"]),
        label:has(> input[type="radio"]),
        [wire\:click]:not(:disabled) {
            cursor: pointer;
        }
        button:disabled,
        [aria-disabled="true"] {
            cursor: not-allowed;
        }
    </style>

    {{-- Barra flutuante de formatação: aparece ao selecionar texto no editor --}}
    <div x-data="trixLinkToolbar" x-cloak x-show="show" @mousedown.prevent
        :style="`position:fixed; top:${y}px; left:${x}px; z-index:70;`"
        class="flex items-center gap-1 bg-secondary text-white rounded-xl shadow-2xl px-1.5 py-1">
        <button type="button" @click="toggle('bold')" class="w-8 h-8 rounded-lg hover:bg-white/15 font-bold" title="Negrito">B</button>
        <button type="button" @click="toggle('italic')" class="w-8 h-8 rounded-lg hover:bg-white/15 italic" title="Itálico">I</button>
        <span class="w-px h-5 bg-white/20 mx-0.5"></span>
        <button type="button" @click="makeLink()" class="px-2 h-8 rounded-lg hover:bg-white/15 flex items-center gap-1 text-sm font-bold" title="Inserir link">
            <span class="material-symbols-outlined text-base">link</span> Link
        </button>
        <button type="button" @click="unlink()" class="w-8 h-8 rounded-lg hover:bg-white/15 flex items-center justify-center" title="Remover link">
            <span class="material-symbols-outlined text-base">link_off</span>
        </button>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('trixLinkToolbar', () => ({
                show: false, x: 0, y: 0, editorEl: null,
                init() {
                    document.addEventListener('selectionchange', () => this.onSelection());
                    window.addEventListener('scroll', () => { this.show = false; }, true);
                },
                onSelection() {
                    const sel = window.getSelection();
                    if (!sel || sel.rangeCount === 0 || sel.isCollapsed) { this.show = false; return; }
                    let node = sel.anchorNode;
                    node = node && (node.nodeType === 1 ? node : node.parentElement);
                    const editorEl = node ? node.closest('trix-editor') : null;
                    if (!editorEl) { this.show = false; return; }
                    const rect = sel.getRangeAt(0).getBoundingClientRect();
                    if (!rect.width) { this.show = false; return; }
                    this.editorEl = editorEl;
                    this.x = Math.max(8, rect.left + (rect.width / 2) - 95);
                    this.y = Math.max(8, rect.top - 50);
                    this.show = true;
                },
                editor() { return this.editorEl.editor; },
                toggle(attr) {
                    const e = this.editor();
                    e.setSelectedRange(e.getSelectedRange());
                    e.attributeIsActive(attr) ? e.deactivateAttribute(attr) : e.activateAttribute(attr);
                },
                makeLink() {
                    const e = this.editor();
                    const range = e.getSelectedRange();
                    const current = e.attributeIsActive('href') ? '' : 'https://';
                    const url = window.prompt('Cole o endereço do link (URL):', current);
                    this.show = false;
                    if (url === null) return;
                    e.setSelectedRange(range);
                    url.trim() === '' ? e.deactivateAttribute('href') : e.activateAttribute('href', url.trim());
                },
                unlink() {
                    const e = this.editor();
                    e.setSelectedRange(e.getSelectedRange());
                    e.deactivateAttribute('href');
                    this.show = false;
                },
            }));
        });
    </script>
</body>

</html>