@props(['src' => null, 'alt' => '', 'label' => true])

{{-- Placeholder da marca SOPAPE. Fica atrás e aparece quando não há imagem OU
     quando a imagem falha ao carregar. O elemento PAI precisa ser position:relative. --}}
<span aria-hidden="true" data-sopape-placeholder="1"
    class="absolute inset-0 z-0 flex flex-col items-center justify-center gap-1.5 p-2 select-none bg-gradient-to-br from-secondary to-primary">
    <svg viewBox="0 0 32 32" class="h-2/5 max-h-16 min-h-[22px] w-auto opacity-95" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M16 26 C 16 26 4 18.5 4 11.5 C 4 8 6.8 5.5 10 5.5 C 12.5 5.5 14.8 7 16 9 C 17.2 7 19.5 5.5 22 5.5 C 25.2 5.5 28 8 28 11.5 C 28 18.5 16 26 16 26 Z"
            fill="#ffffff" />
    </svg>
    @if($label)
        <span class="text-white font-heading font-bold tracking-[0.2em] text-[10px] sm:text-xs">SOPAPE</span>
    @endif
</span>
@if($src)
    <img src="{{ $src }}" alt="{{ $alt }}"
        {{ $attributes->merge(['class' => 'relative z-10 w-full h-full object-cover']) }}
        onerror="this.remove()">
@endif
