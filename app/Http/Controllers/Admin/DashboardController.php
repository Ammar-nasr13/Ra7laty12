<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\NewsletterSubscriber;
use App\Models\Trip;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings    = Booking::count();
        $totalRevenue     = Booking::where('status', 'confirmed')->sum('total_price');
        $activeTrips      = Trip::active()->count();
        $totalSubscribers = NewsletterSubscriber::count();

        $recentBookings = Booking::latest()
            ->take(10)
            ->get();

        $allBookings = Booking::all();

        // Top Trips
        $topTrips = $allBookings->groupBy('trip_id')
            ->map(function ($group, $tripId) {
                $first = $group->first();
                $trip = $first ? $first->trip : null;
                return (object)[
                    'trip_id' => $tripId,
                    'total' => $group->count(),
                    'trip' => $trip
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();

        // Monthly bookings for last 6 months
        $monthlyBookings = $allBookings->filter(function ($b) {
                return $b->created_at && $b->created_at >= now()->subMonths(6);
            })
            ->groupBy(function ($b) {
                return $b->created_at->format('Y-m');
            })
            ->map(function ($group) {
                $first = $group->first();
                return (object)[
                    'month' => $first->created_at->month,
                    'year' => $first->created_at->year,
                    'total' => $group->count(),
                ];
            })
            ->values();

        return view('admin.dashboard.index', compact(
            'totalBookings', 'totalRevenue',
            'activeTrips', 'totalSubscribers',
            'recentBookings', 'topTrips', 'monthlyBookings'
        ));
    }
}
