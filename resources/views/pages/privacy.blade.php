<x-layouts.app title="Política de Privacidade">
    <div class="bg-white py-16 px-4 sm:px-6 lg:px-8 lg:py-24">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <span class="text-primary font-bold uppercase tracking-widest text-xs mb-2 block">Privacidade</span>
                <h1 class="text-3xl md:text-4xl font-heading font-extrabold text-secondary">Política de Privacidade</h1>
                <p class="mt-3 text-slate-500">Última atualização: {{ now()->translatedFormat('F \d\e Y') }}</p>
            </div>

            <div class="prose prose-blue prose-lg text-gray-600 mx-auto">
                <p>A <strong>Sociedade Paraense de Pediatria (SOPAPE)</strong> valoriza a privacidade dos seus visitantes
                    e sócios. Esta política explica como coletamos, usamos e protegemos seus dados pessoais, em
                    conformidade com a <strong>Lei Geral de Proteção de Dados (LGPD — Lei nº 13.709/2018)</strong>.</p>

                <h3>1. Dados que coletamos</h3>
                <ul>
                    <li><strong>Dados de cadastro:</strong> nome e e-mail, quando você cria uma conta ou se torna sócio.
                    </li>
                    <li><strong>Dados de contato:</strong> informações que você envia voluntariamente pelo formulário de
                        contato.</li>
                    <li><strong>Dados de navegação:</strong> cookies e métricas de acesso (páginas visitadas, tempo de
                        permanência) coletados por ferramentas de análise, como o Google Analytics.</li>
                </ul>

                <h3>2. Cookies e análise de tráfego</h3>
                <p>Utilizamos cookies para melhorar a experiência de navegação e entender como o site é utilizado. Você
                    pode gerenciar ou desativar cookies nas configurações do seu navegador. Ao continuar navegando,
                    você consente com o uso de cookies conforme descrito aqui.</p>

                <h3>3. Como usamos seus dados</h3>
                <p>Utilizamos seus dados para operar e melhorar o site, responder aos seus contatos, enviar comunicações
                    institucionais e cumprir obrigações legais. <strong>Não vendemos</strong> seus dados pessoais.</p>

                <h3>4. Compartilhamento</h3>
                <p>Seus dados podem ser compartilhados apenas com prestadores de serviço essenciais à operação do site
                    (por exemplo, hospedagem e análise de tráfego) e quando exigido por lei.</p>

                <h3>5. Seus direitos (LGPD)</h3>
                <p>Você pode, a qualquer momento, solicitar o acesso, a correção, a portabilidade ou a exclusão dos seus
                    dados, bem como revogar consentimentos. Para exercer esses direitos, entre em contato conosco.</p>

                <h3>6. Segurança</h3>
                <p>Adotamos medidas técnicas e organizacionais para proteger seus dados contra acesso não autorizado,
                    perda ou alteração indevida.</p>

                <h3>7. Contato</h3>
                <p>Para dúvidas sobre esta política ou sobre seus dados, escreva para
                    <strong>{{ \App\Models\SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com') }}</strong>
                    ou use nossa <a href="{{ route('pages.contact') }}">página de contato</a>.</p>
            </div>
        </div>
    </div>
</x-layouts.app>
