<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.index');
    }

    public function store(StoreSurveyRequest $request)
    {
        $response = SurveyResponse::create($request->validated());

        session(['survey_response_id' => $response->id]);

        return redirect()->route('survey.results', $response->id);
    }

    public function results(SurveyResponse $response)
    {
        return view('survey.results', compact('response'));
    }
}
