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
    ];

    protected $casts = [
        'year' => 'integer',
    ];
}
