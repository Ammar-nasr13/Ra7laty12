<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'review' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }
}
