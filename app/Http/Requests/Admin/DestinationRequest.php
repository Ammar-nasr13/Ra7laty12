<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id'       => 'nullable|exists:countries,id',
            'name.ar'          => 'required|string|max:150',
            'name.en'          => 'required|string|max:150',
            'description.ar'   => 'required|string',
            'description.en'   => 'required|string',
            'category'         => 'required|in:beach,culture,adventure,heritage',
            'is_featured'      => 'boolean',
            'sort_order'       => 'nullable|integer|min:0',
            'image'            => 'nullable|image|max:2048',
            'gallery.*'        => 'nullable|image|max:4096',
            'meta_title.ar'    => 'nullable|string|max:60',
            'meta_title.en'    => 'nullable|string|max:60',
            'meta_desc.ar'     => 'nullable|string|max:160',
            'meta_desc.en'     => 'nullable|string|max:160',
            'meta_keywords.ar' => 'nullable|string|max:255',
            'meta_keywords.en' => 'nullable|string|max:255',
        ];
    }
}
