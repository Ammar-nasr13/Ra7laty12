<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $budget
 * @property string $travel_type
 * @property string $preferred_climate
 * @property string $duration_preference
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $message
 */
class SurveyResponse extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'budget',
        'travel_type',
        'preferred_climate',
        'duration_preference',
        'message',
    ];

    /**
     * Returns the subset of fields used by the JS matchTrips() function
     * on the results page.
     */
    public function toMatchArray(): array
    {
        return [
            'budget'      => $this->budget,
            'travel_type' => $this->travel_type,
            'climate'     => $this->preferred_climate,
            'duration'    => $this->duration_preference,
        ];
    }
}
