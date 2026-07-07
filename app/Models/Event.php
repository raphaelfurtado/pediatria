<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'date_start',
        'date_end',
        'location',
        'image_path',
        'type',
        'registration_link',
        'is_featured',
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('date_start', '>=', now())->orderBy('date_start');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
