/**
 * Salvamento automático de rascunho no navegador (localStorage) para formulários
 * Livewire do painel — protege contra queda de internet, aba fechada ou sessão
 * expirada. Nada vai para o servidor: o texto só é publicado ao clicar em Salvar.
 *
 * Uso (via <x-admin.draft-autosave>):
 *   x-data="draftAutosave('u1:post:5', ['title', 'content'])"
 */

const PREFIX = 'sopape-draft:';
const INTERVAL_MS = 5000;
// O Trix normaliza o HTML ao carregar; espera ele terminar antes de fixar o "estado salvo".
const SETTLE_MS = 1500;

const same = (a, b) => JSON.stringify(a) === JSON.stringify(b);

function read(key) {
    try {
        return JSON.parse(localStorage.getItem(key));
    } catch {
        return null;
    }
}

function write(key, value) {
    try {
        localStorage.setItem(key, JSON.stringify(value));
        return true;
    } catch {
        return false; // modo anônimo / armazenamento cheio: segue sem autosave
    }
}

function remove(key) {
    try {
        localStorage.removeItem(key);
    } catch {
        // ignora
    }
}

function hasErrors(snapshot) {
    try {
        const parsed = typeof snapshot === 'string' ? JSON.parse(snapshot) : snapshot;
        return Object.keys(parsed?.memo?.errors ?? {}).length > 0;
    } catch {
        return true; // na dúvida, não apaga o rascunho
    }
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data('draftAutosave', (key, fields) => ({
        storageKey: PREFIX + key,
        draft: null,
        savedAt: null,
        baseline: null,
        saving: false,

        init() {
            setTimeout(() => this.start(), SETTLE_MS);
        },

        start() {
            this.baseline = this.snapshot();

            const stored = read(this.storageKey);
            if (stored?.data && !same(stored.data, this.baseline)) {
                this.draft = stored;
            } else {
                remove(this.storageKey);
            }

            setInterval(() => this.persist(), INTERVAL_MS);

            // Depois de um "Salvar" sem erros de validação, o rascunho local não é mais necessário.
            // "saving" evita o aviso de "sair da página" no redirecionamento após salvar.
            window.Livewire.hook('commit', ({ component, commit, succeed, fail }) => {
                if (component.id !== this.$wire.$id || !commit.calls?.some((c) => c.method === 'save')) {
                    return;
                }
                this.saving = true;
                fail(() => {
                    this.saving = false;
                });
                succeed(({ snapshot }) => {
                    if (hasErrors(snapshot)) {
                        this.saving = false;
                        return;
                    }
                    this.baseline = this.snapshot();
                    this.discard();
                    // Edição sem redirecionamento: volta a vigiar alterações.
                    setTimeout(() => {
                        this.saving = false;
                    }, 1000);
                });
            });

            window.addEventListener('beforeunload', (event) => {
                if (!this.saving && !this.draft && !same(this.snapshot(), this.baseline)) {
                    this.persist();
                    event.preventDefault();
                    event.returnValue = '';
                }
            });
        },

        snapshot() {
            return Object.fromEntries(fields.map((f) => [f, this.$wire[f] ?? '']));
        },

        persist() {
            // Há um rascunho antigo esperando decisão: não sobrescreve.
            if (this.draft) {
                return;
            }

            const data = this.snapshot();
            if (same(data, this.baseline)) {
                remove(this.storageKey);
                this.savedAt = null;
                return;
            }

            if (write(this.storageKey, { data, at: Date.now() })) {
                this.savedAt = new Date();
            }
        },

        restore() {
            const data = this.draft.data;

            fields.forEach((f) => {
                this.$wire[f] = data[f];
            });

            // O conteúdo vive no editor Trix; recarrega o HTML nele (o trix-change atualiza o Livewire).
            const trix = this.$root.closest('[wire\\:id]')?.querySelector('trix-editor');
            if (trix && 'content' in data) {
                trix.editor.loadHTML(data.content ?? '');
            }

            this.draft = null;
            this.persist();
        },

        discard() {
            remove(this.storageKey);
            this.draft = null;
            this.savedAt = null;
        },

        time(value) {
            return new Date(value).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        },

        date(value) {
            const d = new Date(value);
            const today = new Date().toDateString() === d.toDateString();
            return today ? `hoje às ${this.time(value)}` : `${d.toLocaleDateString('pt-BR')} às ${this.time(value)}`;
        },
    }));
});
