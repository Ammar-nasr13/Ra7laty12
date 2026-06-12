<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                => ['required', 'string', 'max:100'],
            'email'               => ['required', 'email', 'max:200'],
            'phone'               => ['nullable', 'string', 'max:30'],
            'budget'              => ['required', 'in:low,medium,high,luxury'],
            'travel_type'         => ['required', 'in:family,couple,solo,friends'],
            'preferred_climate'   => ['required', 'in:beach,desert,mountain,city'],
            'duration_preference' => ['required', 'in:weekend,week,twoweeks,month'],
            'message'             => ['nullable', 'string', 'max:1000'],
        ];
    }
}
