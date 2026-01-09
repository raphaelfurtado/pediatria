<x-layouts.app :title="$publication->title">
    <section class="py-12 bg-surface-light">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
                <div class="flex flex-col md:flex-row">
                    <!-- Left: Cover -->
                    <div class="md:w-1/3 bg-slate-50 p-8 flex justify-center items-center border-r border-slate-50">
                        <div
                            class="w-64 aspect-[3/4] shadow-2xl rounded-xl overflow-hidden transform hover:scale-105 transition-transform duration-500">
                            <img src="{{ $publication->cover_image ?? 'https://via.placeholder.com/300x400?text=SOPAPE' }}"
                                alt="{{ $publication->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Right: Info -->
                    <div class="md:w-2/3 p-8 md:p-12 flex flex-col justify-center">
                        <div class="mb-6">
                            <span
                                class="bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-4 inline-block">
                                {{ ucfirst($publication->type) }}
                            </span>
                            <h1 class="text-3xl md:text-4xl font-heading font-extrabold text-secondary mb-4">
                                {{ $publication->title }}
                            </h1>
                            @if($publication->year)
                                <div class="text-slate-400 font-bold flex items-center gap-2 mb-6">
                                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                                    Ano de Publicação: {{ $publication->year }}
                                </div>
                            @endif
                        </div>

                        <div class="prose prose-slate max-w-none mb-10 text-slate-600 leading-relaxed">
                            {!! nl2br(e($publication->description)) !!}
                        </div>

                        <div class="flex flex-wrap gap-4">
                            @if($publication->file_path)
                                <a href="{{ $publication->file_path }}" target="_blank"
                                    class="bg-primary hover:bg-secondary text-white font-bold py-4 px-8 rounded-full shadow-lg shadow-primary/20 transition-all flex items-center gap-2 text-lg">
                                    <span class="material-symbols-outlined">download</span>
                                    Baixar PDF
                                </a>
                            @endif

                            @if($publication->external_link)
                                <a href="{{ $publication->external_link }}" target="_blank"
                                    class="bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-bold py-4 px-8 rounded-full transition-all flex items-center gap-2 text-lg">
                                    <span class="material-symbols-outlined">link</span>
                                    Acessar Link Externo
                                </a>
                            @endif

                            <a href="{{ route('publications.index') }}"
                                class="w-full md:w-auto text-slate-400 hover:text-secondary font-bold py-4 px-4 flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined">arrow_back</span>
                                Voltar para Biblioteca
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>