<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCard extends Model
{
    use HasFactory;

    /**
     * Allowed color themes. Kept in sync with the theme map in home.blade.php.
     * (Tailwind needs the literal class strings in a scanned Blade file, so the
     * actual CSS classes live there — this list only drives selects/validation.)
     */
    public const COLORS = ['primary', 'accent', 'rose', 'success'];

    protected $fillable = [
        'title',
        'description',
        'icon',
        'color',
        'link',
        'cta_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];
}
