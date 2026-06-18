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
            'slug'    => [
                'required',
                'string',
                'max:60',
                'regex:/^[a-z0-9\-]+$/',
                function ($attribute, $value, $fail) use ($id) {
                    $query = \App\Models\Country::where('slug', $value);
                    if ($id) {
                        $query = $query->where('id', '!=', $id);
                    }
                    if ($query->exists()) {
                        $fail(__('validation.unique', ['attribute' => 'slug']));
                    }
                }
            ],
            'flag'    => 'nullable|string|max:10',
        ];
    }
}
