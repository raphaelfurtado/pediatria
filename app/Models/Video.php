<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'youtube_id',
        'provider',
        'thumbnail_url',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $attributes = [
        'provider' => 'youtube',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getProviderNameAttribute(): string
    {
        return $this->provider === 'vimeo' ? 'Vimeo' : 'YouTube';
    }

    /**
     * URL do player para incorporar (iframe).
     */
    public function embedUrl(): string
    {
        return $this->provider === 'vimeo'
            ? "https://player.vimeo.com/video/{$this->youtube_id}"
            : "https://www.youtube.com/embed/{$this->youtube_id}";
    }

    /**
     * URL para assistir na origem (nova aba).
     */
    public function watchUrl(): string
    {
        return $this->provider === 'vimeo'
            ? "https://vimeo.com/{$this->youtube_id}"
            : "https://www.youtube.com/watch?v={$this->youtube_id}";
    }

    /**
     * Miniatura: usa a salva (Vimeo) ou a computada do YouTube.
     */
    public function thumbUrl(): ?string
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        return $this->provider === 'vimeo'
            ? null
            : "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
    }

    /**
     * Extrai provedor + ID de um link (ou ID) colado pelo usuário.
     *
     * @return array{provider: string, id: string}
     */
    public static function parseReference(string $input): array
    {
        $input = trim($input);

        // Vimeo: vimeo.com/123456789 ou player.vimeo.com/video/123456789
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~i', $input, $m)) {
            return ['provider' => 'vimeo', 'id' => $m[1]];
        }

        // YouTube: watch?v=, youtu.be/, embed/, shorts/
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~i', $input, $m)) {
            return ['provider' => 'youtube', 'id' => $m[1]];
        }

        // ID puro do YouTube (11 caracteres)
        if (preg_match('~^[A-Za-z0-9_-]{11}$~', $input)) {
            return ['provider' => 'youtube', 'id' => $input];
        }

        // ID puro numérico (Vimeo)
        if (preg_match('~^\d+$~', $input)) {
            return ['provider' => 'vimeo', 'id' => $input];
        }

        // Fallback: trata como ID do YouTube
        return ['provider' => 'youtube', 'id' => $input];
    }
}
