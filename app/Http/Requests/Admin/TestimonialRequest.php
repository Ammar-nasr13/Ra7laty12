<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:100',
            'review'    => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'avatar'    => 'nullable|image|max:1024',
        ];
    }
}
