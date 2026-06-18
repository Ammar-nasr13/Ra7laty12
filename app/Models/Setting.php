<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class Setting extends AppwriteModel
{
    protected string $collectionName = 'settings';

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

    /**
     * Custom updateOrCreate implementation for settings
     */
    public static function updateOrCreate(array $attributes, array $values = [])
    {
        $key = $attributes['key'] ?? null;
        if ($key) {
            $existing = static::where('key', $key)->first();
            if ($existing) {
                $existing->value = $values['value'] ?? $existing->value;
                $existing->group = $values['group'] ?? $existing->group;
                $existing->save();
                return $existing;
            }
        }
        $model = new static(array_merge($attributes, $values));
        $model->save();
        return $model;
    }
}
