<x-layouts.app title="Sobre" description="Conheça a Sociedade Paraense de Pediatria (SOPAPE): missão, história e atuação na saúde da criança e do adolescente.">
    <div class="bg-white py-16 px-4 overflow-hidden sm:px-6 lg:px-8 lg:py-24">
        <div class="relative max-w-xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ \App\Models\SiteSetting::get('about_title', 'Sobre a SOPAPE') }}
                </h2>
                <p class="mt-4 text-lg leading-6 text-gray-500">
                    {{ \App\Models\SiteSetting::get('about_subtitle', 'Sociedade Paraense de Pediatria') }}
                </p>
            </div>
            <div class="mt-12">
                <div class="prose prose-blue prose-lg text-gray-500 mx-auto">
                    {!! \App\Models\SiteSetting::get('about_content', \App\Livewire\Admin\About\Form::defaultContent()) !!}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
