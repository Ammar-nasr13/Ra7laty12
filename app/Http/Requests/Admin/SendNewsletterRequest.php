<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SendNewsletterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipients' => 'required|in:subscribers,bookers,all',
            'subject'    => 'required|string|max:255',
            'body'       => 'required|string',
        ];
    }
}
