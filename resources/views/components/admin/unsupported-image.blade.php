{{-- Aviso no lugar da prévia quando o arquivo enviado não é uma imagem visualizável (ex.: HEIC do iPhone). --}}
<div {{ $attributes->merge(['class' => 'flex items-start gap-2 rounded-xl border border-amber-200 bg-amber-50 p-3 text-left text-xs text-amber-800']) }}>
    <span class="material-symbols-outlined text-base">warning</span>
    <span><strong>Formato não suportado.</strong> Envie a imagem em JPG, PNG ou WebP. Fotos do iPhone (HEIC) precisam ser convertidas antes.</span>
</div>
