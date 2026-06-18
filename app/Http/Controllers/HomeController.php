<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\Trip;
use App\Models\Country;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)->with('media')->get();

        $egypt = Country::where('slug', 'egypt')->first();
        $egyptDestinations = $egypt
            ? Destination::where('country_id', $egypt->id)
                ->orderBy('sort_order')
                ->take(6)
                ->get()
            : collect();

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
