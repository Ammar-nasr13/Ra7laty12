<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'slug', 'flag', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
