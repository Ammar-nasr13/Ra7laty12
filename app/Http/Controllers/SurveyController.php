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
        try {
            $response = SurveyResponse::create($request->validated());
            if ($response && $response->exists && !empty($response->id)) {
                session(['survey_response_id' => $response->id]);
                return redirect()->route('survey.results', $response->id);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("SurveyResponse save failed: " . $e->getMessage());
        }

        // Fallback: Save answers in session and redirect with a dummy ID 'session'
        $data = $request->validated();
        $data['id'] = 'session';
        session(['survey_fallback_data' => $data]);
        
        return redirect()->route('survey.results', 'session');
    }

    public function results($responseId)
    {
        if ($responseId === 'session') {
            $data = session('survey_fallback_data');
            if (!$data) {
                return redirect()->route('survey.index');
            }
            $response = new SurveyResponse($data, false);
            $response->id = 'session';
        } else {
            $response = SurveyResponse::find($responseId);
            if (!$response) {
                abort(404);
            }
        }

        return view('survey.results', compact('response'));
    }
}
