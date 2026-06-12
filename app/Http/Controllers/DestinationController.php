<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function show(Destination $destination)
    {
        $trips = $destination->trips()
            ->active()
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('destinations.show', compact('destination', 'trips'));
    }

    public function index(Request $request)
    {
        $countries = Country::where('is_active', true)->orderBy('slug')->get();

        $query = Destination::with(['country', 'media'])
            ->withCount('trips')
            ->orderBy('sort_order');

        if ($request->filled('country')) {
            $query->whereHas('country', fn($q) => $q->where('slug', $request->input('country')));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $destinations = $query->get();

        return view('destinations.index', compact('destinations', 'countries'));
    }
}
