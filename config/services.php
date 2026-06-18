<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'appwrite' => [
        'endpoint' => env('APPWRITE_ENDPOINT', 'https://appwrite.etihadalmdina.com/v1'),
        'project_id' => env('APPWRITE_PROJECT_ID', '69f21c73000621939422'),
        'api_key' => env('APPWRITE_API_KEY'),
        'database_id' => env('APPWRITE_DATABASE_ID', '6a32ee91000b40dd8d3c'),
        'collections' => [
            'countries' => env('APPWRITE_COUNTRIES_COLLECTION', 'countries'),
            'destinations' => env('APPWRITE_DESTINATIONS_COLLECTION', 'destinations'),
            'trips' => env('APPWRITE_TRIPS_COLLECTION', 'trips'),
            'bookings' => env('APPWRITE_BOOKINGS_COLLECTION', 'bookings'),
            'testimonials' => env('APPWRITE_TESTIMONIALS_COLLECTION', 'testimonials'),
            'surveys' => env('APPWRITE_SURVEYS_COLLECTION', 'survey_responses'),
            'subscribers' => env('APPWRITE_SUBSCRIBERS_COLLECTION', 'newsletter_subscribers'),
            'admins' => env('APPWRITE_ADMINS_COLLECTION', 'admins'),
            'settings' => env('APPWRITE_SETTINGS_COLLECTION', 'settings'),
        ],
    ],

];
