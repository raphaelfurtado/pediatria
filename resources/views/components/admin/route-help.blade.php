@php
    $route = request()->route()?->getName();

    $helps = [
        'admin.dashboard' => ['Visão geral do site: números gerais, últimas notícias (clique no título para abrir/editar) e próximos eventos.'],
        'admin.slides.index' => ['Estes são os banners do carrossel no topo da página inicial.', 'Clique em "Novo Banner" para adicionar (título, imagem, ordem e ativar/desativar).'],
        'admin.service-cards.index' => ['Os 4 blocos coloridos que aparecem logo abaixo do banner na home.', 'Edite título, ícone, cor, link e ordem. Desative o que não quiser exibir.'],
        'admin.about' => ['Edite aqui o texto da página pública /sobre usando o editor de texto (negrito, títulos, listas).'],
        'admin.messages.index' => ['Mensagens enviadas pelo formulário público de contato.', 'Marque como lida, responda por e-mail (botão responder) ou exclua.'],
        'admin.posts.index' => ['Notícias e artigos do site.', 'Atenção: "Rascunho" NÃO aparece no site — só quando o status vira "Publicado".', 'O ícone de olho abre a matéria; marque "Destaque" para ela ir para a home.'],
        'admin.events.index' => ['Eventos e cursos.', 'Marque "Destaque" para o evento aparecer primeiro na agenda da home.'],
        'admin.publications.index' => ['Biblioteca: livros, manuais, guias e revistas, com capa e link ou arquivo.'],
        'admin.albums.index' => ['Álbuns de fotos exibidos na Galeria do site.'],
        'admin.videos.index' => ['Vídeos do YouTube.', 'Use o ID do vídeo (o código depois de "watch?v=").', '"Vídeo Ativo" mostra em /videos; "Destaque na Home" coloca o vídeo na página inicial.'],
        'admin.users.index' => ['Usuários do painel.', 'Administrador acessa tudo; Editor gerencia apenas conteúdo.', 'Use "Novo Usuário" para cadastrar e definir a função.'],
        'admin.navigation.index' => ['Itens do menu do site.', 'Edite o texto e a URL de cada item, ative/desative e use as setas para reordenar.'],
        'admin.settings' => ['Aqui ficam: redes sociais, contato (e-mail/telefone exibidos), banner "Publique seu artigo", bloco do rodapé e o campo do Google Analytics.'],
    ];

    $tips = $helps[$route] ?? null;
@endphp

@if($tips)
    <div x-data="{ open: false }" x-init="open = ! localStorage.getItem('help_{{ $route }}')" x-show="open"
        style="display: none;" class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3 mb-6">
        <span class="material-symbols-outlined text-primary flex-shrink-0">tips_and_updates</span>
        <div class="flex-1 text-sm text-slate-600">
            <div class="font-bold text-secondary mb-1">Como usar esta seção</div>
            <ul class="list-disc ml-4 space-y-0.5">
                @foreach($tips as $tip)
                    <li>{{ $tip }}</li>
                @endforeach
            </ul>
            <a href="{{ route('admin.manual') }}" class="inline-block mt-2 text-primary font-bold text-xs">Ver manual
                completo &rarr;</a>
        </div>
        <button type="button" @click="localStorage.setItem('help_{{ $route }}', '1'); open = false"
            class="text-slate-400 hover:text-slate-600 flex-shrink-0" title="Não mostrar novamente">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
@endif
