<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected const CACHE_KEY = 'site_settings.all';

    /**
     * Invalidate the settings cache whenever a setting changes.
     */
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    /**
     * Get setting by key with optional default value (served from cache).
     */
    public static function get($key, $default = null)
    {
        $settings = Cache::rememberForever(
            self::CACHE_KEY,
            fn () => self::pluck('value', 'key')->all(),
        );

        return $settings[$key] ?? $default;
    }

    /**
     * Set setting by key.
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
