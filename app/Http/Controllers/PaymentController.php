<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Services\CurrencyService;
use App\Services\PaymobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function __construct(
        private PaymobService $paymob,
        private CurrencyService $currency,
    ) {}

    public function redirect(Booking $booking)
    {
        if ($booking->paid_at) {
            return redirect()->route('trips.book.confirmed', $booking->trip_id)
                ->with('booking_ref', $booking->reference)
                ->with('booking_id', $booking->id);
        }

        $egpAmount  = round($this->currency->usdToEgpCents($booking->total_price) / 100, 2);

        $token      = $this->paymob->getAuthToken();
        $orderId    = $this->paymob->createOrder($token, $booking);
        $paymentKey = $this->paymob->getPaymentKey($token, $orderId, $booking);

        $booking->update([
            'paymob_order_id' => $orderId,
            'paid_amount_egp' => $egpAmount,
        ]);

        return redirect($this->paymob->getIframeUrl($paymentKey));
    }

    public function callback(Request $request)
    {
        $success = $request->query('success') === 'true';
        $orderId = $request->query('order');

        $booking = Booking::where('paymob_order_id', $orderId)->first();

        if (!$booking) {
            return redirect()->route('home');
        }

        if ($success) {
            return redirect()->route('trips.book.confirmed', $booking->trip_id)
                ->with('booking_ref', $booking->reference)
                ->with('booking_id', $booking->id);
        }

        return redirect()->route('trips.book', $booking->trip_id)
            ->with('error', app()->getLocale() === 'ar' ? 'فشل الدفع، يرجى المحاولة مجدداً.' : 'Payment failed, please try again.');
    }

    public function webhook(Request $request)
    {
        $data = $request->all();
        $hmac = $request->query('hmac');

        if (!$hmac || !$this->paymob->validateHmac($data, $hmac)) {
            return response('Unauthorized', 401);
        }

        // Paymob wraps transaction data inside "obj"
        $obj     = $data['obj'] ?? $data;
        $success = $obj['success'] ?? false;

        if ($success !== true && $success !== 'true') {
            return response('ok');
        }

        $transactionId = $obj['id'] ?? null;
        $orderId       = $obj['order']['id'] ?? null;

        $booking = Booking::where('paymob_order_id', $orderId)->first();

        if ($booking && !$booking->paid_at) {
            $booking->update([
                'status'                => 'confirmed',
                'paymob_transaction_id' => $transactionId,
                'paid_at'               => now(),
                'confirmed_at'          => $booking->confirmed_at ?? now(),
            ]);

            $booking->load(['trip.destination', 'trip.media']);
            Mail::to($booking->email)
                ->send(new BookingConfirmation($booking, $booking->trip, 'en'));
        }

        return response('ok');
    }
}
