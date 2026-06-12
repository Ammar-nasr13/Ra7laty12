<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * Get a setting value by key, with optional default.
     * Results are cached to avoid repeated DB queries.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return static::all()->pluck('value', 'key');
        });

        return $settings->get($key, $default);
    }

    /**
     * Update or create a setting value and flush cache.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget('site_settings');
    }
}
