<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;

class PaymobService
{
    private string $baseUrl;
    private string $apiKey;
    private int $integrationId;
    private string $iframeId;

    public function __construct(private CurrencyService $currency)
    {
        $this->baseUrl       = config('paymob.base_url');
        $this->apiKey        = config('paymob.api_key');
        $this->integrationId = (int) config('paymob.integration_id');
        $this->iframeId      = config('paymob.iframe_id');
    }

    public function getAuthToken(): string
    {
        $response = Http::post("{$this->baseUrl}/auth/tokens", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json('token');
    }

    private function toEgpCents(float $usdAmount): int
    {
        return $this->currency->usdToEgpCents($usdAmount);
    }

    public function createOrder(string $token, Booking $booking): int
    {
        $amountCents = $this->toEgpCents($booking->total_price);

        $response = Http::post("{$this->baseUrl}/ecommerce/orders", [
            'auth_token'                => $token,
            'delivery_needed'           => false,
            'amount_cents'              => $amountCents,
            'currency'                  => 'EGP',
            'merchant_order_id'         => $booking->reference,
            'items'                     => [],
        ]);

        return $response->json('id');
    }

    public function getPaymentKey(string $token, int $orderId, Booking $booking): string
    {
        $amountCents = $this->toEgpCents($booking->total_price);

        $response = Http::post("{$this->baseUrl}/acceptance/payment_keys", [
            'auth_token'     => $token,
            'amount_cents'   => $amountCents,
            'expiration'     => 3600,
            'order_id'       => $orderId,
            'currency'       => 'EGP',
            'integration_id' => $this->integrationId,
            'redirect_url'   => route('payment.callback'),
            'billing_data'   => [
                'apartment'       => 'N/A',
                'email'           => $booking->email,
                'floor'           => 'N/A',
                'first_name'      => $booking->name,
                'last_name'       => 'N/A',
                'street'          => 'N/A',
                'building'        => 'N/A',
                'phone_number'    => $booking->phone,
                'shipping_method' => 'N/A',
                'postal_code'     => 'N/A',
                'city'            => 'Cairo',
                'country'         => 'EG',
                'state'           => 'N/A',
            ],
        ]);

        return $response->json('token');
    }

    public function getIframeUrl(string $paymentKey): string
    {
        return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentKey}";
    }

    public function validateHmac(array $data, string $hmac): bool
    {
        $secret = config('paymob.hmac_secret');

        // Exact concatenation order as per Paymob docs
        $obj = $data['obj'] ?? $data;

        $concatenated =
            ($obj['amount_cents']            ?? '') .
            ($obj['created_at']              ?? '') .
            ($obj['currency']                ?? '') .
            ($obj['error_occured']           ?? '') .
            ($obj['has_parent_transaction']  ?? '') .
            ($obj['id']                      ?? '') .
            ($obj['integration_id']          ?? '') .
            ($obj['is_3d_secure']            ?? '') .
            ($obj['is_auth']                 ?? '') .
            ($obj['is_capture']              ?? '') .
            ($obj['is_refunded']             ?? '') .
            ($obj['is_standalone_payment']   ?? '') .
            ($obj['is_voided']               ?? '') .
            ($obj['order']['id']             ?? '') .
            ($obj['owner']                   ?? '') .
            ($obj['pending']                 ?? '') .
            ($obj['source_data']['pan']      ?? '') .
            ($obj['source_data']['sub_type'] ?? '') .
            ($obj['source_data']['type']     ?? '') .
            ($obj['success']                 ?? '');

        return hash_equals(hash('sha512', $concatenated . $secret), $hmac);
    }
}
