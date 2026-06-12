<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title.ar'            => 'required|string|max:200',
            'title.en'            => 'required|string|max:200',
            'destination_id'      => 'nullable|exists:destinations,id',
            'desc.ar'             => 'required|string',
            'desc.en'             => 'required|string',
            'highlights.ar'       => 'required|array|min:1',
            'highlights.ar.*'     => 'required|string',
            'highlights.en'       => 'required|array|min:1',
            'highlights.en.*'     => 'required|string',
            'highlight_images.*'  => 'nullable|image|max:2048',
            'gallery.*'           => 'nullable|image|max:4096',
            'price'               => 'required|numeric|min:0',
            'duration'            => 'required|integer|min:1',
            'category'            => 'required|in:beach,culture,adventure',
            'climate'             => 'required|in:beach,desert,mountain,city',
            'travel_type'         => 'required|array|min:1',
            'travel_type.*'       => 'in:family,couple,solo,friends',
            'budget_tier'         => 'required|in:low,medium,high,luxury',
            'is_egyptian'         => 'boolean',
            'spots_total'         => 'required|integer|min:1',
            'spots_left'          => 'required|integer|min:0',
            'departure_dates'     => 'nullable|array',
            'departure_dates.*'   => 'date',
            'included.ar'         => 'nullable|array',
            'included.ar.*'       => 'nullable|string|max:300',
            'included.en'         => 'nullable|array',
            'included.en.*'       => 'nullable|string|max:300',
            'excluded.ar'         => 'nullable|array',
            'excluded.ar.*'       => 'nullable|string|max:300',
            'excluded.en'         => 'nullable|array',
            'excluded.en.*'       => 'nullable|string|max:300',
            'itinerary.ar'        => 'nullable|array',
            'itinerary.ar.*'      => 'nullable|string',
            'itinerary.en'        => 'nullable|array',
            'itinerary.en.*'      => 'nullable|string',
            'image'               => 'nullable|image|max:2048',
            'is_active'           => 'boolean',
            'sort_order'          => 'nullable|integer|min:0',
            'meta_title.ar'       => 'nullable|string|max:60',
            'meta_title.en'       => 'nullable|string|max:60',
            'meta_desc.ar'        => 'nullable|string|max:160',
            'meta_desc.en'        => 'nullable|string|max:160',
            'meta_keywords.ar'    => 'nullable|string|max:255',
            'meta_keywords.en'    => 'nullable|string|max:255',
        ];
    }
}
