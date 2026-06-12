<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBookingStatusRequest;
use App\Mail\TripCompleted;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('trip');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('reference', 'like', "%$s%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('trip');
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(UpdateBookingStatusRequest $request, Booking $booking)
    {
        $data = ['status' => $request->input('status')];

        if ($request->input('status') === 'confirmed' && !$booking->confirmed_at) {
            $data['confirmed_at'] = now();
        }

        $booking->update($data);

        if ($request->input('status') === 'completed') {
            $booking->load('trip');
            Mail::to($booking->email)->queue(
                new TripCompleted($booking, $booking->trip, 'en')
            );
        }

        return back()->with('success', 'تم تحديث حالة الحجز.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم حذف الحجز.');
    }
}
