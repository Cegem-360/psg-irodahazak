<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip locale detection for language switch routes to prevent conflicts
        if ($request->is('language/*')) {
            return $next($request);
        }

        // First check if we're on an English route
        $locale = 'hu'; // default

        if ($request->is('en') || $request->is('en/*')) {
            $locale = 'en';
            Session::put('locale', 'en');
        } else {
            // Get locale from session, fallback to config default
            $locale = Session::get('locale', config('app.locale'));
        }

        // Ensure the locale is supported
        if (in_array($locale, ['hu', 'en'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
