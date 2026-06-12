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

        $recentBookings = Booking::with('trip')
            ->latest()
            ->take(10)
            ->get();

        $topTrips = Booking::selectRaw('trip_id, count(*) as total')
            ->groupBy('trip_id')
            ->orderByDesc('total')
            ->with('trip')
            ->take(5)
            ->get();

        // Monthly bookings for last 6 months
        $monthlyBookings = Booking::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        return view('admin.dashboard.index', compact(
            'totalBookings', 'totalRevenue',
            'activeTrips', 'totalSubscribers',
            'recentBookings', 'topTrips', 'monthlyBookings'
        ));
    }
}
