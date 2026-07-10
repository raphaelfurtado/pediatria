<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'event',
        'subject_type',
        'subject_id',
        'description',
        'properties',
        'ip_address',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Human, gendered pt-BR label for a subject model ("a notícia", "o evento"...).
     */
    public static function labelFor(Model $model): string
    {
        return match ($model::class) {
            \App\Models\Post::class => 'a notícia',
            \App\Models\Event::class => 'o evento',
            \App\Models\Publication::class => 'a publicação',
            \App\Models\Video::class => 'o vídeo',
            \App\Models\User::class => 'o usuário',
            \App\Models\ServiceCard::class => 'o card',
            \App\Models\Slide::class => 'o destaque',
            \App\Models\PhotoAlbum::class => 'a galeria',
            default => 'o registro',
        };
    }
}
