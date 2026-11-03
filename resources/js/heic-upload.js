/**
 * Converte fotos HEIC/HEIF (padrão do iPhone) para JPG no navegador antes do
 * upload do Livewire — o servidor (GD) não lê HEIC.
 *
 * Intercepta o "change" de qualquer <input type="file" wire:model> na fase de
 * captura; se houver HEIC entre os arquivos, converte e envia via $wire.upload().
 * A biblioteca (~1,4MB) só é baixada quando um HEIC aparece.
 */

const HEIC_TYPES = ['image/heic', 'image/heif', 'image/heic-sequence', 'image/heif-sequence'];

const isHeic = (file) => HEIC_TYPES.includes(file.type.toLowerCase()) || /\.(heic|heif)$/i.test(file.name);

function modelName(input) {
    const attr = [...input.attributes].find((a) => a.name.startsWith('wire:model'));
    return attr ? attr.value : null;
}

function showStatus(message) {
    const el = document.createElement('div');
    el.className = 'fixed bottom-6 right-6 z-50 px-6 py-3 rounded-xl shadow-2xl text-white font-bold flex items-center gap-3 bg-secondary';
    el.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span><span></span>';
    el.lastElementChild.textContent = message;
    document.body.appendChild(el);

    return el;
}

// Fotos de iPhone viram JPGs de 4–6MB; reduzimos para caber no limite de upload
// (o servidor redimensiona para 1600px de qualquer forma).
const MAX_SIDE = 2000;

async function shrink(blob) {
    const bitmap = await createImageBitmap(blob);
    const scale = Math.min(1, MAX_SIDE / Math.max(bitmap.width, bitmap.height));
    const canvas = document.createElement('canvas');
    canvas.width = Math.round(bitmap.width * scale);
    canvas.height = Math.round(bitmap.height * scale);
    canvas.getContext('2d').drawImage(bitmap, 0, 0, canvas.width, canvas.height);
    bitmap.close();

    return new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.85));
}

async function convert(file) {
    const { default: heic2any } = await import('heic2any');
    const result = await heic2any({ blob: file, toType: 'image/jpeg', quality: 0.9 });
    const blob = await shrink(Array.isArray(result) ? result[0] : result);
    const name = file.name.replace(/\.(heic|heif)$/i, '') + '.jpg';

    return new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() });
}

document.addEventListener(
    'change',
    async (event) => {
        const input = event.target;

        if (!(input instanceof HTMLInputElement) || input.type !== 'file' || !input.files?.length) {
            return;
        }

        const files = [...input.files];
        const model = modelName(input);
        const root = input.closest('[wire\\:id]');

        if (!files.some(isHeic) || !model || !root || !window.Livewire) {
            return;
        }

        // Impede o upload padrão do Livewire; reenviamos os arquivos convertidos abaixo.
        event.stopImmediatePropagation();

        const $wire = window.Livewire.find(root.getAttribute('wire:id'));
        const status = showStatus('Convertendo foto do iPhone (HEIC)…');

        let converted;
        try {
            converted = await Promise.all(files.map((file) => (isHeic(file) ? convert(file) : file)));
        } catch (error) {
            console.error('Falha ao converter HEIC:', error);
            converted = files; // o servidor mostra o aviso de formato não suportado
        }

        const done = () => status.remove();

        if (input.multiple) {
            $wire.uploadMultiple(model, converted, done, done);
        } else {
            $wire.upload(model, converted[0], done, done);
        }

        input.value = '';
    },
    true,
);
