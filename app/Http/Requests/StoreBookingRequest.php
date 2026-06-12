<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:150',
            'phone'          => 'required|string|max:20',
            'adults'         => 'required|integer|min:1|max:10',
            'children'       => 'required|integer|min:0|max:10',
            'travel_date'    => 'required|date',
            'payment_method' => 'required|in:paymob',
            'notes'          => 'nullable|string|max:500',
        ];
    }
}
