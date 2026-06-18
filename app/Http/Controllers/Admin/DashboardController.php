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
                $date = $b->created_at;
                if (!$date) return false;
                if (is_string($date)) {
                    try {
                        $date = \Illuminate\Support\Carbon::parse($date);
                    } catch (\Exception $e) {
                        return false;
                    }
                }
                return $date instanceof \Illuminate\Support\Carbon && $date >= now()->subMonths(6);
            })
            ->groupBy(function ($b) {
                $date = $b->created_at;
                if (is_string($date)) {
                    try {
                        $date = \Illuminate\Support\Carbon::parse($date);
                    } catch (\Exception $e) {
                        return 'unknown';
                    }
                }
                return $date instanceof \Illuminate\Support\Carbon ? $date->format('Y-m') : 'unknown';
            })
            ->filter(function ($group, $key) {
                return $key !== 'unknown';
            })
            ->map(function ($group) {
                $first = $group->first();
                $date = $first->created_at;
                if (is_string($date)) {
                    $date = \Illuminate\Support\Carbon::parse($date);
                }
                return (object)[
                    'month' => $date->month,
                    'year' => $date->year,
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
