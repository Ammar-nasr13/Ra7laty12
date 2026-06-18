<?php

namespace App\Models;

class Testimonial extends AppwriteModel
{
    protected string $collectionName = 'testimonials';

    public function booking()
    {
        return $this->booking_id ? Booking::find($this->booking_id) : null;
    }

    /**
     * Get review text based on locale (fallback to comment_ar or comment_en)
     */
    public function getReviewAttribute(): string
    {
        $lang = app()->getLocale();
        $key = "comment_{$lang}";
        return $this->attributes[$key] ?? ($this->attributes['comment_ar'] ?? ($this->attributes['comment_en'] ?? ''));
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar_url ?: 'https://i.pravatar.cc/200?img=11';
    }

    /**
     * Fallback for Spatie Medialibrary compatibility
     */
    public function getFirstMediaUrl(string $collection = 'avatar'): string
    {
        return $this->avatar_url ?: '';
    }

    public function getFirstMedia(string $collection = 'avatar')
    {
        if (empty($this->avatar_url)) return null;

        return new class($this->avatar_url) {
            protected string $url;
            public function __construct($url) { $this->url = $url; }
            public function getUrl() { return $this->url; }
        };
    }
}
