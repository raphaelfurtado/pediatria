<footer class="bg-secondary text-blue-100 pt-20 pb-10 rounded-t-4xl md:rounded-t-5xl mt-12 overflow-hidden relative">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary opacity-10 rounded-full blur-3xl -mr-20 -mt-20"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary shadow-lg">
                        <span class="material-symbols-outlined text-2xl">child_care</span>
                    </div>
                    <span class="text-2xl font-heading font-extrabold text-white">SOPAPE</span>
                </div>
                <p class="text-sm leading-relaxed text-blue-200">
                    Comprometidos com a ciência, a ética e a defesa profissional da pediatria paraense desde sua
                    fundação.
                </p>
                <div class="flex gap-3">
                    <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent hover:text-secondary transition-all"
                        href="#"><span class="material-symbols-outlined text-lg">social_leaderboard</span></a>
                    <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent hover:text-secondary transition-all"
                        href="#"><span class="material-symbols-outlined text-lg">photo_camera</span></a>
                    <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent hover:text-secondary transition-all"
                        href="#"><span class="material-symbols-outlined text-lg">smart_display</span></a>
                </div>
            </div>
            <div>
                <h5 class="text-white font-bold mb-6 text-lg tracking-tight">Navegação Rápida</h5>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a class="hover:text-accent transition-colors flex items-center gap-2"
                            href="{{ route('pages.about') }}"><span
                                class="material-symbols-outlined text-xs">chevron_right</span> Institucional</a></li>
                    <li><a class="hover:text-accent transition-colors flex items-center gap-2"
                            href="{{ route('publications.index') }}"><span
                                class="material-symbols-outlined text-xs">chevron_right</span> Artigos e Projetos</a>
                    </li>
                    <li><a class="hover:text-accent transition-colors flex items-center gap-2"
                            href="{{ route('events.index') }}"><span
                                class="material-symbols-outlined text-xs">chevron_right</span> Cursos e Eventos</a></li>
                    <li><a class="hover:text-accent transition-colors flex items-center gap-2"
                            href="{{ route('posts.index') }}"><span
                                class="material-symbols-outlined text-xs">chevron_right</span> Notícias</a></li>
                    <li><a class="hover:text-accent transition-colors flex items-center gap-2" href="#"><span
                                class="material-symbols-outlined text-xs">chevron_right</span> Contato</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-bold mb-6 text-lg tracking-tight">Fale Conosco</h5>
                <ul class="space-y-4 text-sm font-medium">
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-accent">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                        </div>
                        <span class="mt-1">Rua dos Pariquis, 2999 - A<br />Sala 1304, Belém - PA</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-accent">
                            <span class="material-symbols-outlined text-sm">mail</span>
                        </div>
                        <span class="break-all">atendimento.sopape@gmail.com</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-accent">
                            <span class="material-symbols-outlined text-sm">call</span>
                        </div>
                        <span>(91) 99999-9999</span>
                    </li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-bold mb-6 text-lg tracking-tight">Localização</h5>
                <div
                    class="w-full h-40 bg-slate-800 rounded-2xl flex items-center justify-center border border-white/10 overflow-hidden relative group cursor-pointer">
                    <img alt="Map Placeholder"
                        class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-70 transition-opacity"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAVx6Nb14DZk126asGbTXn9i_VLwBJTUJO3NhRh5QihNcMIXQ6VkeMpDZkNeDPo9XduyGwrAbz4Pakr1Oylrf4mPQs89Bjt7sBYiI13yIhX_rk-E9h-kW6FdhycT3Su0SSqUcLa2-Ap6Ofz9IjHXX1Eyk3U4dSJSMT6WplYClBnIOWdzEzoGbwL5RLmIJQaMYhEpX9lqo7VikyNo-fxYuxZWo5pQckLM4SH4M0WRkimYuxxcrwWC6Ff0vjniVjNDWUqfWtyJebIZ9g"
                        style="background-color: #334155;" />
                    <span class="material-symbols-outlined text-4xl text-white relative z-10 drop-shadow-md">map</span>
                </div>
            </div>
        </div>
        <div
            class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-blue-300">
            <p>© 2025 Sociedade Paraense de Pediatria. Todos os direitos reservados.</p>
            <div class="flex gap-6">
                <a class="hover:text-white transition-colors" href="#">Política de Privacidade</a>
                <a class="hover:text-white transition-colors" href="#">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>