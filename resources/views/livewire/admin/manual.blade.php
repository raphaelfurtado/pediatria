<div class="max-w-4xl mx-auto space-y-8" id="manual">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headings font-bold text-secondary">Manual de Uso do Painel</h1>
            <p class="text-slate-500 text-sm">Guia rápido para gerenciar o site da SOPAPE. Cada seção abaixo
                corresponde a um item do menu à esquerda.</p>
        </div>
        <button onclick="window.print()"
            class="no-print bg-white border border-slate-200 text-slate-600 hover:text-primary font-bold py-2 px-4 rounded-full text-sm flex items-center gap-2 flex-shrink-0">
            <span class="material-symbols-outlined text-lg">print</span> Imprimir
        </button>
    </div>

    <!-- Índice -->
    <div class="no-print bg-white rounded-2xl border border-slate-100 p-5">
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Índice</div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-1 text-sm">
            @foreach([
                'acesso' => 'Acesso ao painel',
                'conceitos' => 'Conceitos importantes',
                'destaques' => 'Destaques (Banners)',
                'cards' => 'Cards da Home',
                'sobre' => 'Página Sobre',
                'noticias' => 'Notícias',
                'eventos' => 'Eventos',
                'publicacoes' => 'Publicações',
                'galerias' => 'Galerias',
                'videos' => 'Vídeos',
                'mensagens' => 'Mensagens',
                'usuarios' => 'Usuários',
                'menu' => 'Menu e Navegação',
                'config' => 'Configurações',
            ] as $anchor => $label)
                <a href="#{{ $anchor }}" class="text-primary hover:underline">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    @php
        $sections = [
            ['acesso', 'lock', 'Acesso ao painel', [
                'Entre pelo endereço <b>/login</b> (ou /admin) com seu e-mail e senha.',
                'Esqueceu a senha? Clique em <b>"Esqueceu sua senha?"</b> na tela de login e siga o link enviado por e-mail.',
                'Para sair, use o botão <b>Sair</b> no rodapé do menu lateral.',
            ]],
            ['conceitos', 'lightbulb', 'Conceitos importantes (leia primeiro)', [
                '<b>Publicado × Rascunho</b> (notícias): só o que está <b>Publicado</b> aparece no site. Rascunho fica salvo, mas invisível ao público.',
                '<b>Ativo × Inativo</b> (banners, vídeos, cards, menu): itens inativos ficam ocultos no site sem precisar excluir.',
                '<b>Destaque na Home</b>: coloca aquele item (notícia, vídeo, evento) em posição de destaque na página inicial.',
                '<b>Ordem</b>: número que define a sequência de exibição (menor aparece primeiro).',
                '<b>Salvar sempre</b>: nenhuma alteração vale até você clicar em <b>Salvar</b>.',
            ]],
            ['destaques', 'view_carousel', 'Destaques (Home) — Banners do carrossel', [
                'São as imagens grandes que passam no <b>topo da página inicial</b>.',
                'Clique em <b>"Novo Banner"</b> para adicionar: título, subtítulo, imagem, texto/link do botão, ordem e ativo.',
                'Para tirar um banner do ar sem apagar, basta <b>desativar</b>.',
            ]],
            ['cards', 'dashboard_customize', 'Cards da Home', [
                'São os <b>4 blocos coloridos</b> logo abaixo do banner (ex.: "Seja um Sócio", "Calendário Vacinal").',
                'Você edita <b>título, descrição, ícone, cor, link e ordem</b> de cada um.',
                'Ícones: use nomes do <b>Material Symbols</b> (fonts.google.com/icons). Cores disponíveis: Azul, Amarelo, Vermelho, Verde.',
            ]],
            ['sobre', 'info', 'Página Sobre', [
                'Edita o conteúdo da página pública <b>/sobre</b> com um editor de texto (negrito, títulos, listas).',
                'Clique em <b>Salvar</b> e use "Ver página" para conferir.',
            ]],
            ['noticias', 'article', 'Notícias', [
                'Clique em <b>"Nova Notícia"</b>: preencha título, conteúdo (editor), categoria e imagem.',
                '<b>Status:</b> deixe em "Publicado" para aparecer no site; "Rascunho" mantém salvo e invisível.',
                'Marque <b>Destaque</b> para a notícia virar a manchete principal da home.',
                'Na lista, o ícone de <b>olho</b> abre a matéria pública; o lápis edita; a lixeira exclui.',
            ]],
            ['eventos', 'event', 'Eventos', [
                'Cadastre cursos, congressos e encontros com data, local, tipo e link de inscrição.',
                'Marque <b>Destaque</b> para o evento aparecer primeiro na agenda da home.',
            ]],
            ['publicacoes', 'library_books', 'Publicações (Biblioteca)', [
                'Livros, manuais, guias e revistas exibidos em <b>/biblioteca</b>.',
                'Inclua capa, tipo, ano e um link externo ou arquivo.',
            ]],
            ['galerias', 'photo_library', 'Galerias', [
                'Crie <b>álbuns de fotos</b> exibidos na Galeria do site.',
                'A primeira foto do álbum vira a capa.',
            ]],
            ['videos', 'movie', 'Vídeos', [
                'Adicione vídeos colando o <b>link</b> do YouTube ou do Vimeo — o sistema detecta e incorpora sozinho.',
                '<b>Vídeo Ativo</b>: aparece na página /videos.',
                '<b>Destaque na Home</b>: aparece também na seção de vídeos da página inicial.',
            ]],
            ['mensagens', 'forum', 'Mensagens', [
                'Aqui chegam as mensagens enviadas pelo <b>formulário de contato</b> do site.',
                'As <b>não lidas</b> aparecem destacadas e no contador do menu. Marque como lida, responda por e-mail ou exclua.',
                'Obs.: o envio por e-mail depende da configuração de SMTP; mesmo sem e-mail, tudo fica salvo aqui.',
            ]],
            ['usuarios', 'group', 'Usuários (apenas Administrador)', [
                'Clique em <b>"Novo Usuário"</b>: nome, e-mail, senha e <b>função</b>.',
                '<b>Administrador</b>: acessa tudo, inclusive Usuários, Menu e Configurações.',
                '<b>Editor</b>: gerencia conteúdo (notícias, eventos, vídeos, etc.), sem acesso ao Sistema.',
                'Para trocar a senha de alguém, edite o usuário e digite uma nova (deixe em branco para manter a atual).',
            ]],
            ['menu', 'menu_open', 'Menu e Navegação (apenas Administrador)', [
                'Controla os itens do <b>menu do site</b> (topo).',
                'Edite o <b>texto</b> e a <b>URL</b> de cada item (ex.: Contato → /contato), ative/desative e use as <b>setas</b> para reordenar.',
            ]],
            ['config', 'settings', 'Configurações (apenas Administrador)', [
                '<b>Redes sociais</b>: links do Facebook, Instagram, etc. (aparecem no rodapé).',
                '<b>Contato</b>: e-mail e telefone exibidos no site e destino das mensagens de contato.',
                '<b>Banner "Publique seu artigo"</b>: liga/desliga e edita o box azul da home.',
                '<b>Marketing</b>: bloco "Receba novidades" do rodapé.',
                '<b>Scripts &amp; Analytics</b>: cole aqui o código do <b>Google Analytics</b> — ele entra automaticamente no site.',
            ]],
        ];
    @endphp

    @foreach($sections as [$anchor, $icon, $title, $items])
        <section id="{{ $anchor }}" class="bg-white rounded-2xl border border-slate-100 p-6 scroll-mt-6">
            <h2 class="text-lg font-bold text-secondary flex items-center gap-2 mb-4">
                <span class="w-9 h-9 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">{{ $icon }}</span>
                </span>
                {{ $title }}
            </h2>
            <ul class="space-y-2 text-sm text-slate-600">
                @foreach($items as $item)
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span>
                        <span>{!! $item !!}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    @endforeach

    <p class="no-print text-center text-xs text-slate-400 pt-4">
        Precisa de algo que não está aqui? Fale com o administrador do site.
    </p>

    <style>
        @media print {
            .no-print { display: none !important; }
            aside { display: none !important; }
        }
    </style>
</div>
