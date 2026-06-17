<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\Trip;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)->with('media')->get();

        $egyptDestinations = Destination::whereHas('country', fn($q) => $q->where('slug', 'egypt'))
            ->with(['country', 'media'])
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('home', compact('testimonials', 'egyptDestinations'));
    }

    public function sitemap()
    {
        $trips = Trip::active()->orderBy('sort_order')->get();
        $destinations = Destination::orderBy('sort_order')->get();
        return response()
            ->view('sitemap', compact('trips', 'destinations'))
            ->header('Content-Type', 'application/xml');
    }

    public function setLang(string $locale)
    {
        session(['locale' => $locale]);
        app()->setLocale($locale);

        return redirect()->back();
    }

    public function setAdminLang(string $locale)
    {
        session(['admin_locale' => $locale]);

        return redirect()->back();
    }
}
