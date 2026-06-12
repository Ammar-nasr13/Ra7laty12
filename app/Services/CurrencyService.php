<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    private const FALLBACK = [
        'EGP' => 50.0,
        'EUR' => 0.92,
        'GBP' => 0.79,
        'SAR' => 3.75,
        'AED' => 3.67,
        'KWD' => 0.31,
        'QAR' => 3.64,
    ];

    public function getRates(): array
    {
        return Cache::remember('exchange_rates_usd', 6 * 3600, function () {
            $response = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');

            if ($response->ok() && $response->json('result') === 'success') {
                return $response->json('rates');
            }

            return array_merge(['USD' => 1.0], self::FALLBACK);
        });
    }

    public function getRate(string $currency): float
    {
        $rates = $this->getRates();
        return (float) ($rates[$currency] ?? self::FALLBACK[$currency] ?? 1.0);
    }

    public function usdToEgpCents(float $usdAmount): int
    {
        return (int) round($usdAmount * $this->getRate('EGP') * 100);
    }
}
