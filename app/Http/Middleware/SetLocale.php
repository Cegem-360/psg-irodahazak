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
        // Check if the current path is any English route
        if ($request->is('offices-for-rent') ||
            $request->is('home') ||
            $request->is('data-sheet') ||
            $request->is('office-buildings-for-sale') ||
            $request->is('about-us') ||
            $request->is('privacy-policy') ||
            $request->is('contact-us') ||
            $request->is('properties') ||
            $request->is('office-to-let/*') ||
            $request->is('office-to-sale/*') ||
            $request->is('favorites') ||
            $request->is('news-blog') ||
            $request->is('news-blog/*') ||
            $request->is('news') ||
            $request->is('news/*') ||
            $request->is('budapest-en/*')) {
            App::setLocale('en');
            Session::put('locale', 'en');
        } elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
