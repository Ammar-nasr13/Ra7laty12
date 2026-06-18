<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin;

// ─── Front-end Routes ───────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/trips/{id}', [TripController::class, 'show'])->name('trips.show');

Route::get('/trips/{id}/book',      [BookingController::class, 'show'])->name('trips.book');
Route::post('/trips/{id}/book',     [BookingController::class, 'store'])->name('trips.book.store');
Route::get('/trips/{id}/confirmed', [BookingController::class, 'confirmed'])->name('trips.book.confirmed');

Route::post('/lang/{locale}', [HomeController::class, 'setLang'])
    ->name('lang.switch')
    ->where('locale', 'ar|en');

Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/review/{booking}',  [ReviewController::class, 'form'])->name('review.form');
Route::post('/review/{booking}', [ReviewController::class, 'store'])->name('review.store');

Route::get('/pay/{booking}',      [PaymentController::class, 'redirect'])->name('payment.redirect');
Route::get('/payment/callback',   [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/webhook',   [PaymentController::class, 'webhook'])->name('payment.webhook')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/survey/results/{response}', [SurveyController::class, 'results'])->name('survey.results');

// Temporary/helper route to seed Appwrite from browser
Route::get('/seed-database', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('appwrite:seed');
        return '<h3>Appwrite Database Seeded Successfully!</h3><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return '<h3>Error Seeding Database:</h3><pre>' . $e->getMessage() . '</pre>';
    }
});

// Temporary route to view laravel logs from browser
Route::get('/view-logs', function() {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) {
        return 'Log file not found.';
    }
    $content = file_get_contents($logPath);
    $lines = explode("\n", $content);
    $lastLines = array_slice($lines, -200);
    return '<h3>Last 200 Lines of Laravel Log:</h3><pre>' . htmlspecialchars(implode("\n", $lastLines)) . '</pre>';
});

// ─── Admin Routes ───────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (no middleware)
    Route::get('/login',   [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // Protected admin area
    Route::middleware('auth.admin')->group(function () {

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Trips
        Route::resource('trips', Admin\TripController::class)->names([
            'index'   => 'trips.index',
            'create'  => 'trips.create',
            'store'   => 'trips.store',
            'show'    => 'trips.show',
            'edit'    => 'trips.edit',
            'update'  => 'trips.update',
            'destroy' => 'trips.destroy',
        ]);
        Route::patch('trips/{trip}/toggle', [Admin\TripController::class, 'toggleActive'])->name('trips.toggle');

        // Bookings
        Route::resource('bookings', Admin\BookingController::class)
            ->except(['create', 'store', 'edit'])
            ->names([
                'index'   => 'bookings.index',
                'show'    => 'bookings.show',
                'update'  => 'bookings.update',
                'destroy' => 'bookings.destroy',
            ]);
        Route::patch('bookings/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('bookings.status');

        // Countries
        Route::resource('countries', Admin\CountryController::class)->names([
            'index'   => 'countries.index',
            'create'  => 'countries.create',
            'store'   => 'countries.store',
            'show'    => 'countries.show',
            'edit'    => 'countries.edit',
            'update'  => 'countries.update',
            'destroy' => 'countries.destroy',
        ]);

        // Destinations
        Route::resource('destinations', Admin\DestinationController::class)->names([
            'index'   => 'destinations.index',
            'create'  => 'destinations.create',
            'store'   => 'destinations.store',
            'show'    => 'destinations.show',
            'edit'    => 'destinations.edit',
            'update'  => 'destinations.update',
            'destroy' => 'destinations.destroy',
        ]);

        // Testimonials (read + delete only — created by customers via booking flow)
        Route::resource('testimonials', Admin\TestimonialController::class)
            ->only(['index', 'show', 'destroy'])
            ->names([
                'index'   => 'testimonials.index',
                'show'    => 'testimonials.show',
                'destroy' => 'testimonials.destroy',
            ]);
        Route::patch('testimonials/{testimonial}/toggle', [Admin\TestimonialController::class, 'toggleActive'])
            ->name('testimonials.toggle');

        // Newsletter Subscribers
        Route::get('subscribers',                  [Admin\SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('subscribers/export',           [Admin\SubscriberController::class, 'exportCsv'])->name('subscribers.export');
        Route::post('subscribers/send',            [Admin\SubscriberController::class, 'sendNewsletter'])->name('subscribers.send');
        Route::delete('subscribers/{subscriber}',  [Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        // Survey Responses
        Route::get('surveys',             [Admin\SurveyController::class, 'index'])->name('surveys.index');
        Route::get('surveys/{survey}',    [Admin\SurveyController::class, 'show'])->name('surveys.show');

        // Settings
        Route::get('settings',            [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings',           [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::post('lang/{locale}', [HomeController::class, 'setAdminLang'])
            ->name('lang.switch')
            ->where('locale', 'ar|en');
    });
});
