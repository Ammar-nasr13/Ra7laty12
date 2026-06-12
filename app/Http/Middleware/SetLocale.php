<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionKey = $request->is('admin*') ? 'admin_locale' : 'locale';
        $locale = session($sessionKey, 'ar');

        if (!in_array($locale, ['ar', 'en'])) {
            $locale = 'ar';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
