<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Destination extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name', 'description', 'meta_title', 'meta_desc', 'meta_keywords'];

    protected $fillable = [
        'country_id', 'name', 'description',
        'category', 'is_featured', 'sort_order',
        'meta_title', 'meta_desc', 'meta_keywords',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }
}
