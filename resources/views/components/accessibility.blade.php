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

{{-- VLibras (tradução para Libras) — o botão de acesso fica acima do WhatsApp, à direita --}}
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
