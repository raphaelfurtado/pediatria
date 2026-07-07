<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_album_id',
        'image_path',
        'title',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(PhotoAlbum::class, 'photo_album_id');
    }
}
