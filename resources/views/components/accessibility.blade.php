{{-- Widget de acessibilidade (fonte + alto contraste) — canto inferior esquerdo --}}
<div x-cloak x-data="{
        open: false,
        hc: false,
        size: 0,
        init() {
            this.size = parseInt(localStorage.getItem('a11y_size') || '0');
            this.applyFont();
            this.hc = localStorage.getItem('a11y_hc') === '1';
            document.documentElement.classList.toggle('hc', this.hc);
        },
        applyFont() {
            document.documentElement.style.fontSize = (100 + this.size * 10) + '%';
            localStorage.setItem('a11y_size', this.size);
        },
        inc() { if (this.size < 4) { this.size++; this.applyFont(); } },
        dec() { if (this.size > -2) { this.size--; this.applyFont(); } },
        reset() { this.size = 0; this.applyFont(); },
        toggleContrast() {
            this.hc = !this.hc;
            document.documentElement.classList.toggle('hc', this.hc);
            localStorage.setItem('a11y_hc', this.hc ? '1' : '0');
        }
    }" class="fixed bottom-6 left-6 z-[70] print:hidden">
    <div class="relative">
        <button @click="open = !open" aria-label="Opções de acessibilidade" title="Acessibilidade"
            class="w-12 h-12 rounded-full bg-primary text-white shadow-2xl ring-2 ring-white flex items-center justify-center hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined">accessibility_new</span>
        </button>

        <div x-show="open" x-cloak @click.outside="open = false" x-transition
            class="absolute bottom-14 left-0 w-60 bg-white rounded-2xl shadow-2xl border border-slate-100 p-3 space-y-2"
            role="menu" aria-label="Acessibilidade">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-1">Acessibilidade</p>

            <div class="flex items-center gap-2">
                <button @click="dec()" aria-label="Diminuir fonte"
                    class="flex-1 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm">A−</button>
                <button @click="reset()" aria-label="Fonte padrão"
                    class="py-2 px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 text-xs font-bold">Padrão</button>
                <button @click="inc()" aria-label="Aumentar fonte"
                    class="flex-1 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-base">A+</button>
            </div>

            <button @click="toggleContrast()" :aria-pressed="hc ? 'true' : 'false'"
                class="w-full py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">contrast</span>
                <span x-text="hc ? 'Contraste normal' : 'Alto contraste'">Alto contraste</span>
            </button>
        </div>
    </div>
</div>

{{-- Botão próprio de Libras: fechado (só ícone) e expande ao passar o mouse.
     O clique dispara o widget do VLibras (cujo botão padrão fica oculto). --}}
<button type="button" onclick="var b=document.querySelector('[vw-access-button]'); if (b) { b.click(); }"
    aria-label="Tradução em Libras (VLibras)" title="Tradução em Libras"
    class="group fixed right-6 bottom-24 z-[70] h-12 rounded-full bg-primary text-white shadow-2xl ring-2 ring-white flex items-center overflow-hidden w-12 hover:w-40 focus:w-40 transition-all duration-300 print:hidden">
    <span class="w-12 h-12 flex items-center justify-center flex-shrink-0">
        <span class="material-symbols-outlined">sign_language</span>
    </span>
    <span class="whitespace-nowrap font-bold text-sm pr-4 opacity-0 group-hover:opacity-100 group-focus:opacity-100 transition-opacity">Libras</span>
</button>

{{-- VLibras (tradução para Libras) — botão padrão oculto via CSS; acionado pelo botão acima --}}
<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
        <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>

@push('scripts')
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
@endpush
