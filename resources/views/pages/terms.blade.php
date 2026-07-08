<x-layouts.app title="Termos de Uso">
    <div class="bg-white py-16 px-4 sm:px-6 lg:px-8 lg:py-24">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <span class="text-primary font-bold uppercase tracking-widest text-xs mb-2 block">Termos</span>
                <h1 class="text-3xl md:text-4xl font-heading font-extrabold text-secondary">Termos de Uso</h1>
                <p class="mt-3 text-slate-500">Última atualização: {{ now()->translatedFormat('F \d\e Y') }}</p>
            </div>

            <div class="prose prose-blue prose-lg text-gray-600 mx-auto">
                <p>Ao acessar e utilizar o site da <strong>Sociedade Paraense de Pediatria (SOPAPE)</strong>, você
                    concorda com os termos descritos abaixo.</p>

                <h3>1. Uso do site</h3>
                <p>O conteúdo deste site tem caráter informativo e institucional. As informações de saúde aqui
                    publicadas <strong>não substituem</strong> a consulta, o diagnóstico ou o tratamento realizados por
                    um profissional de saúde qualificado.</p>

                <h3>2. Cadastro e conta</h3>
                <p>Ao criar uma conta, você é responsável por manter a confidencialidade das suas credenciais e por
                    todas as atividades realizadas em seu nome. Informe-nos imediatamente sobre qualquer uso não
                    autorizado.</p>

                <h3>3. Propriedade intelectual</h3>
                <p>Os textos, marcas, logotipos e materiais publicados pertencem à SOPAPE ou a seus respectivos
                    autores. A reprodução sem autorização é proibida.</p>

                <h3>4. Conteúdo de terceiros</h3>
                <p>O site pode conter links para páginas externas. Não nos responsabilizamos pelo conteúdo ou pelas
                    práticas de privacidade de sites de terceiros.</p>

                <h3>5. Limitação de responsabilidade</h3>
                <p>Empenhamo-nos para manter as informações corretas e atualizadas, mas não garantimos que estejam
                    livres de erros. O uso do site é feito por sua conta e risco.</p>

                <h3>6. Alterações</h3>
                <p>Estes termos podem ser atualizados periodicamente. Recomendamos a revisão regular desta página.</p>

                <h3>7. Contato</h3>
                <p>Dúvidas sobre estes termos? Fale conosco em
                    <strong>{{ \App\Models\SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com') }}</strong>
                    ou pela <a href="{{ route('pages.contact') }}">página de contato</a>.</p>
            </div>
        </div>
    </div>
</x-layouts.app>
