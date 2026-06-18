<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Trip;

class BookingController extends Controller
{
    public function show(string $id)
    {
        $trip = Trip::active()->where('id', $id)->firstOrFail();
        return view('trips.booking', compact('trip'));
    }

    public function store(StoreBookingRequest $request, string $id)
    {
        $trip = Trip::active()->where('id', $id)->firstOrFail();

        $validated = $request->validated();

        $ref = strtoupper('BK-' . date('Ymd') . '-' . substr(md5(uniqid()), 0, 6));

        $totalPrice = $trip->price * ($validated['adults'] + ($validated['children'] * 0.5));

        $booking = Booking::create([
            'trip_id'        => $trip->id,
            'reference'      => $ref,
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'],
            'adults'         => $validated['adults'],
            'children'       => $validated['children'],
            'travel_date'    => $validated['travel_date'],
            'payment_method' => $validated['payment_method'],
            'total_price'    => $totalPrice,
            'notes'          => $validated['notes'] ?? null,
            'status'         => 'confirmed',
        ]);

        if ($trip->spots_left > 0) {
            $trip->decrement('spots_left');
        }

        return redirect()->route('payment.redirect', $booking);
    }

    public function confirmed(string $id)
    {
        $trip      = Trip::where('id', '=', $id)->firstOrFail();
        $bookingId = session('booking_id');

        if (!$bookingId) {
            return redirect()->route('trips.book', $id);
        }

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return redirect()->route('trips.book', $id);
        }

        return view('trips.confirmed', compact('trip', 'booking'));
    }
}
