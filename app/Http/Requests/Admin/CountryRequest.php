<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('country')?->id;

        return [
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'slug'    => 'required|string|max:60|unique:countries,slug' . ($id ? ",$id" : '') . '|regex:/^[a-z0-9\-]+$/',
            'flag'    => 'nullable|string|max:10',
        ];
    }
}
