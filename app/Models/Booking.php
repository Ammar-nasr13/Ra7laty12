<?php

namespace App\Models;

class Booking extends AppwriteModel
{
    protected string $collectionName = 'bookings';

    public function trip()
    {
        return $this->trip_id ? Trip::find($this->trip_id) : null;
    }

    public static function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'credit_card'   => 'بطاقة ائتمان',
            'visa'          => 'فيزا',
            'meeza'         => 'ميزة',
            'instapay'      => 'إنستا باي',
            'vodafone_cash' => 'فودافون كاش',
            default         => $this->payment_method ?: '',
        };
    }
}
