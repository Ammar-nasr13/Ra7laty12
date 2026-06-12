<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Trip extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['title', 'desc', 'highlights', 'included', 'excluded', 'itinerary', 'meta_title', 'meta_desc', 'meta_keywords'];

    protected $fillable = [
        'title', 'desc', 'highlights', 'highlight_images',
        'included', 'excluded', 'itinerary',
        'destination_id',
        'price', 'currency', 'duration',
        'category', 'climate', 'travel_type', 'budget_tier',
        'color_from', 'color_to', 'is_egyptian',
        'spots_total', 'spots_left', 'departure_dates',
        'is_active', 'sort_order',
        'meta_title', 'meta_desc', 'meta_keywords',
    ];

    protected $casts = [
        'travel_type'      => 'array',
        'departure_dates'  => 'array',
        'highlight_images' => 'array',
        'is_egyptian'      => 'boolean',
        'is_active'        => 'boolean',
        'price'            => 'decimal:2',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeEgyptian($query)
    {
        return $query->where('is_egyptian', true);
    }

    public function scopeInternational($query)
    {
        return $query->where('is_egyptian', false);
    }

    public function scopeByCategory($query, string $cat)
    {
        return $query->where('category', $cat);
    }

    public function scopeByBudget($query, string $tier)
    {
        return $query->where('budget_tier', $tier);
    }

    public function scopeByTravelType($query, string $type)
    {
        return $query->whereJsonContains('travel_type', $type);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }
}
