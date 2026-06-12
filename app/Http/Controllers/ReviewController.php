<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Booking;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function form(Request $request, string $booking)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'رابط غير صالح أو منتهي الصلاحية.');
        }

        $booking = Booking::where('reference', '=', $booking)
            ->where('status', '=', 'completed')
            ->with('trip')
            ->firstOrFail();

        if (Testimonial::where('booking_id', '=', $booking->id)->exists()) {
            return view('review.already', compact('booking'));
        }

        return view('review.form', compact('booking'));
    }

    public function store(StoreReviewRequest $request, string $booking)
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        $booking = Booking::where('reference', '=', $booking)
            ->where('status', '=', 'completed')
            ->with('trip')
            ->firstOrFail();

        if (Testimonial::where('booking_id', '=', $booking->id)->exists()) {
            return redirect()->route('review.form', ['booking' => $booking->reference])
                ->withErrors(['already' => true]);
        }

        $validated = $request->validated();

        Testimonial::create([
            'booking_id' => $booking->id,
            'name'       => $booking->name,
            'review'     => $validated['review'],
            'rating'     => $validated['rating'],
            'is_active'  => true,
        ]);

        return view('review.thanks', compact('booking'));
    }
}
