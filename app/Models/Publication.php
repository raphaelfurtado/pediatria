<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'cover_image',
        'file_path',
        'external_link',
        'year',
        'order',
    ];

    protected $casts = [
        'year' => 'integer',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        // Nova publicação entra no fim da ordenação.
        static::creating(function (Publication $publication) {
            if (is_null($publication->order)) {
                $publication->order = (static::max('order') ?? 0) + 1;
            }
        });
    }
}
