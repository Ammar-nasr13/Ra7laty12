<?php

namespace App\Models;

class Destination extends AppwriteModel
{
    protected string $collectionName = 'destinations';
    
    public $translatable = ['name', 'description', 'meta_title', 'meta_desc', 'meta_keywords'];

    public function country()
    {
        return $this->country_id ? Country::find($this->country_id) : null;
    }

    public function trips()
    {
        return Trip::where('destination_id', $this->id);
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
        
        // Return dummy object that supports getUrl()
        return new class($this->image_url) {
            protected string $url;
            public function __construct($url) { $this->url = $url; }
            public function getUrl() { return $this->url; }
        };
    }
}
