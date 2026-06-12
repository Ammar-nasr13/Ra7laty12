<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = SurveyResponse::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        if ($request->filled('travel_type')) {
            $query->where('travel_type', $request->input('travel_type'));
        }

        if ($request->filled('budget')) {
            $query->where('budget', $request->input('budget'));
        }

        $surveys = $query->latest()->paginate(20)->withQueryString();

        return view('admin.surveys.index', compact('surveys'));
    }

    public function show(SurveyResponse $survey)
    {
        return view('admin.surveys.show', compact('survey'));
    }
}
