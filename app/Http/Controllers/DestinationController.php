<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function show(Destination $destination)
    {
        try {
            $trips = $destination->trips()
                ->active()
                ->orderBy('id')
                ->get();
        } catch (\Throwable $e) {
            $trips = collect();
        }

        return view('destinations.show', compact('destination', 'trips'));
    }

    public function index(Request $request)
    {
        try {
            $countries = Country::where('is_active', true)->orderBy('slug')->get();
        } catch (\Throwable $e) {
            $countries = collect();
        }

        try {
            $query = Destination::with(['country'])
                ->orderBy('id');

            if ($request->filled('country')) {
                $country = Country::where('slug', $request->input('country'))->first();
                if ($country) {
                    $query->where('country_id', $country->id);
                } else {
                    $query->where('country_id', 'non_existent_id');
                }
            }

            if ($request->filled('category')) {
                $query->where('category', $request->input('category'));
            }

            $destinations = $query->get();
        } catch (\Throwable $e) {
            $destinations = collect();
        }

        return view('destinations.index', compact('destinations', 'countries'));
    }
}
