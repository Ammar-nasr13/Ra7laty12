<?php

namespace App\Models;

class Trip extends AppwriteModel
{
    protected string $collectionName = 'trips';

    public $translatable = ['title', 'desc', 'highlights', 'included', 'excluded', 'itinerary', 'meta_title', 'meta_desc', 'meta_keywords'];

    public function destination()
    {
        return $this->destination_id ? Destination::find($this->destination_id) : null;
    }

    public function bookings()
    {
        return Booking::where('trip_id', $this->id);
    }

    public static function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function scopeEgyptian($query)
    {
        return $query->where('is_egyptian', true);
    }

    public static function scopeInternational($query)
    {
        return $query->where('is_egyptian', false);
    }

    public static function scopeByCategory($query, string $cat)
    {
        return $query->where('category', $cat);
    }

    public static function scopeByBudget($query, string $tier)
    {
        return $query->where('budget_tier', $tier);
    }

    public static function scopeByTravelType($query, string $type)
    {
        return $query->where('travel_type', $type);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_url ?: '';
    }

    /**
     * Fallback for Spatie Medialibrary compatibility
     */
    public function getFirstMediaUrl(string $collection = 'image'): string
    {
        return $this->image_url ?: '';
    }

    public function getFirstMedia(string $collection = 'image')
    {
        if (empty($this->image_url)) return null;

        return new class($this->image_url) {
            protected string $url;
            public function __construct($url) { $this->url = $url; }
            public function getUrl() { return $this->url; }
        };
    }
}
