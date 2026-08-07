<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

/**
 * Otimiza imagens enviadas: redimensiona para uma largura máxima, recomprime
 * em WebP (qualidade alta, arquivo bem menor) e salva no disco "public".
 *
 * Degrada com segurança: se o arquivo não for uma imagem rasterizada suportada,
 * se o GD/WebP não estiver disponível, ou se algo falhar, salva o original
 * sem interromper o upload.
 */
class ImageOptimizer
{
    /** Extensões que convertemos para WebP (gif fica de fora para preservar animação). */
    protected const OPTIMIZABLE = ['jpg', 'jpeg', 'png', 'webp', 'bmp'];

    /**
     * Otimiza (quando possível) e armazena, retornando o caminho relativo no disco public
     * — mesmo formato que UploadedFile::store(), para os chamadores não mudarem nada.
     */
    public static function store(UploadedFile $file, string $directory, int $maxWidth = 1600, int $quality = 82): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (! in_array($extension, self::OPTIMIZABLE, true) || ! self::supported()) {
            return $file->store($directory, 'public');
        }

        try {
            $manager = new ImageManager(new Driver);
            $realPath = $file->getRealPath();

            // A API varia entre versões do intervention/image (read/decodePath/decode).
            $image = match (true) {
                method_exists($manager, 'read') => $manager->read($realPath),
                method_exists($manager, 'decodePath') => $manager->decodePath($realPath),
                default => $manager->decode($realPath),
            };

            if ($image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }

            $path = trim($directory, '/').'/'.Str::random(40).'.webp';
            Storage::disk('public')->put($path, (string) $image->encode(new WebpEncoder(quality: $quality)));

            return $path;
        } catch (\Throwable $e) {
            report($e);

            return $file->store($directory, 'public');
        }
    }

    protected static function supported(): bool
    {
        return extension_loaded('gd') && function_exists('imagewebp');
    }
}
