<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscribeRequest;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterSubscribeRequest $request)
    {
        NewsletterSubscriber::firstOrCreate(
            ['email' => $request->validated()['email']],
            ['is_active' => true]
        );

        return response()->json(['success' => true]);
    }
}
