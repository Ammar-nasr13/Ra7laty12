<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\Trip;
use App\Models\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function submitReview(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'rating' => (int) $validated['rating'],
            'comment_ar' => $validated['comment'],
            'comment_en' => $validated['comment'],
            'is_active' => true,
            'avatar_url' => 'https://i.pravatar.cc/200?img=' . rand(1, 70),
        ]);

        return redirect()->back()->with('success', app()->getLocale() === 'ar' ? 'تم إضافة رأيك بنجاح!' : 'Your review has been submitted successfully!');
    }

    public function index()
    {
        try {
            $testimonials = Testimonial::where('is_active', true)->get();
        } catch (\Throwable $e) {
            $testimonials = collect();
        }

        try {
            $egypt = Country::where('slug', 'egypt')->first();
            $egyptDestinations = $egypt
                ? Destination::where('country_id', $egypt->id)
                    ->take(6)
                    ->get()
                : collect();
        } catch (\Throwable $e) {
            $egyptDestinations = collect();
        }

        return view('home', compact('testimonials', 'egyptDestinations'));
    }

    public function sitemap()
    {
        $sitemapXml = \Illuminate\Support\Facades\Cache::remember('sitemap_xml', 86400, function() {
            try {
                $trips = Trip::active()->orderBy('id')->get();
                $destinations = Destination::orderBy('id')->get();
            } catch (\Throwable $e) {
                $trips = collect();
                $destinations = collect();
            }
            return view('sitemap', compact('trips', 'destinations'))->render();
        });

        return response($sitemapXml)
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
