<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function scopeUpcoming(Builder $query)
    {
        return $query->where('date_start', '>=', now())->orderBy('date_start');
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }
}
