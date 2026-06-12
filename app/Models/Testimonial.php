<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'booking_id', 'name', 'review', 'rating', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating'    => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('avatar');
    }
}
