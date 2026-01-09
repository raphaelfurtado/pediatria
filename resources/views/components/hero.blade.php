@props(['slides' => []])

<div class="relative bg-secondary overflow-hidden group">
    @if($slides->count() > 1)
        <!-- Swiper -->
        <div class="swiper heroSwiper h-[500px] md:h-[600px] lg:h-[700px]">
            <div class="swiper-wrapper">
                @foreach($slides as $slide)
                    <div class="swiper-slide relative">
                        <img src="{{ Storage::url($slide->image_path) }}"
                            class="absolute inset-0 w-full h-full object-cover transform transition-transform duration-[10000ms] group-hover:scale-110"
                            alt="{{ $slide->title }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-secondary/90 via-secondary/40 to-transparent"></div>

                        <div class="container mx-auto px-6 h-full flex items-center relative z-10">
                            <div class="max-w-2xl space-y-6">
                                <span
                                    class="inline-block bg-accent px-4 py-1.5 rounded-full text-secondary text-xs font-bold uppercase tracking-widest animate-fade-in-up">
                                    Destaque da Semana
                                </span>
                                <h1
                                    class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight drop-shadow-lg">
                                    {{ $slide->title }}
                                    <br />
                                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primaryLight to-accent">
                                        {{ $slide->subtitle }}
                                    </span>
                                </h1>
                                @if($slide->button_text)
                                    <div class="flex gap-4 pt-4 animate-fade-in-up delay-300">
                                        @php
                                            $url = $slide->button_link;
                                            if ($url && !Str::startsWith($url, ['http://', 'https://', '/'])) {
                                                $url = 'http://' . $url;
                                            }
                                        @endphp
                                        <a href="{{ $url }}" target="_blank"
                                            class="bg-primary hover:bg-white hover:text-primary text-white px-8 py-3.5 rounded-full font-bold transition-all shadow-xl shadow-primary/20 flex items-center gap-2">
                                            {{ $slide->button_text }}
                                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation -->
            <div
                class="swiper-button-next !text-white !w-12 !h-12 bg-white/10 hover:bg-white/20 backdrop-blur rounded-full after:!text-xl transition-all mr-6">
            </div>
            <div
                class="swiper-button-prev !text-white !w-12 !h-12 bg-white/10 hover:bg-white/20 backdrop-blur rounded-full after:!text-xl transition-all ml-6">
            </div>
            <div class="swiper-pagination !bottom-10"></div>
        </div>
    @elseif($slides->count() == 1)
        @php $slide = $slides->first(); @endphp
        <div class="relative h-[500px] md:h-[600px] lg:h-[700px]">
            <img src="{{ Storage::url($slide->image_path) }}" class="absolute inset-0 w-full h-full object-cover"
                alt="{{ $slide->title }}">
            <div class="absolute inset-0 bg-gradient-to-r from-secondary/90 via-secondary/40 to-transparent"></div>
            <div class="container mx-auto px-6 h-full flex items-center relative z-10">
                <div class="max-w-2xl space-y-6">
                    <span
                        class="inline-block bg-accent px-4 py-1.5 rounded-full text-secondary text-xs font-bold uppercase tracking-widest">
                        Destaque da Semana
                    </span>
                    <h1
                        class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight drop-shadow-lg">
                        {{ $slide->title }}
                        <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primaryLight to-accent">
                            {{ $slide->subtitle }}
                        </span>
                    </h1>
                    @if($slide->button_text)
                        @php
                            $url = $slide->button_link;
                            if ($url && !Str::startsWith($url, ['http://', 'https://', '/'])) {
                                $url = 'http://' . $url;
                            }
                        @endphp
                        <div class="flex gap-4 pt-4">
                            <a href="{{ $url }}" target="_blank"
                                class="bg-primary hover:bg-white hover:text-primary text-white px-8 py-3.5 rounded-full font-bold transition-all shadow-xl shadow-primary/20 flex items-center gap-2">
                                {{ $slide->button_text }}
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Fallback static hero if no slides -->
        <div class="relative bg-secondary h-[500px] flex items-center overflow-hidden">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white">Sociedade Paraense de Pediatria</h1>
                <p class="text-lg text-slate-300 mt-4 max-w-2xl mx-auto">Promovendo a saúde e o bem-estar de crianças e
                    adolescentes no Pará.</p>
            </div>
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
    });
</script>

<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    .delay-100 {
        animation-delay: 0.1s;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: white;
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
        width: 30px;
        border-radius: 6px;
        background: #FFB703;
    }
</style>