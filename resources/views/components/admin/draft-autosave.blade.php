@props(['key', 'fields'])

{{-- Rascunho guardado no navegador a cada 5s; oferece restaurar ao reabrir a tela. --}}
<div wire:ignore x-data="draftAutosave(@js('u'.auth()->id().':'.$key), @js($fields))">
    <template x-if="draft">
        <div class="flex flex-wrap items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
            <span class="material-symbols-outlined">history</span>
            <span class="flex-1">Encontramos um texto <strong>não salvo</strong> deste formulário, de <strong x-text="date(draft.at)"></strong>.</span>
            <button type="button" x-on:click="restore()"
                class="rounded-full bg-amber-500 px-4 py-1.5 font-bold text-white hover:bg-amber-600">Restaurar</button>
            <button type="button" x-on:click="discard()"
                class="rounded-full px-4 py-1.5 font-bold text-amber-800 hover:bg-amber-100">Descartar</button>
        </div>
    </template>
    <p x-show="savedAt && !draft" x-cloak class="flex items-center gap-1 text-xs text-slate-400">
        <span class="material-symbols-outlined text-sm">cloud_done</span>
        Rascunho guardado neste navegador às <span x-text="savedAt && time(savedAt)"></span> — clique em Salvar para publicar as alterações.
    </p>
</div>
