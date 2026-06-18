<?php

namespace App\Models;

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
class SurveyResponse extends AppwriteModel
{
    protected string $collectionName = 'surveys';

    public function __construct(array $attributes = [], bool $exists = false)
    {
        if (isset($attributes['preferred_climate'])) {
            $attributes['climate'] = $attributes['preferred_climate'];
        } else if (isset($attributes['climate'])) {
            $attributes['preferred_climate'] = $attributes['climate'];
        }

        if (isset($attributes['duration_preference'])) {
            $attributes['duration'] = $attributes['duration_preference'];
        } else if (isset($attributes['duration'])) {
            $attributes['duration_preference'] = $attributes['duration'];
        }

        parent::__construct($attributes, $exists);
    }

    public function __get($key)
    {
        if ($key === 'preferred_climate') {
            return $this->attributes['climate'] ?? null;
        }
        if ($key === 'duration_preference') {
            return $this->attributes['duration'] ?? null;
        }
        return parent::__get($key);
    }

    public function __set($key, $value)
    {
        if ($key === 'preferred_climate') {
            $this->attributes['climate'] = $value;
            return;
        }
        if ($key === 'duration_preference') {
            $this->attributes['duration'] = $value;
            return;
        }
        parent::__set($key, $value);
    }

    public function __isset($key)
    {
        if ($key === 'preferred_climate') {
            return isset($this->attributes['climate']);
        }
        if ($key === 'duration_preference') {
            return isset($this->attributes['duration']);
        }
        return parent::__isset($key);
    }

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
