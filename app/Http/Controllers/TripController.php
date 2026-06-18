<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function show(string $id)
    {
        $trip = Trip::with('media')
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        return view('trips.show', compact('trip'));
    }
}
