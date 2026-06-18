<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function show(string $id)
    {
        $trip = Trip::find($id);

        if (!$trip || !$trip->is_active) {
            abort(404);
        }

        return view('trips.show', compact('trip'));
    }
}
