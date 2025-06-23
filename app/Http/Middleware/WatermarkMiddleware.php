<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class WatermarkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Itt ellenőrizhetjük, hogy engedélyezett-e a vízjelezés
        // és beállíthatunk egy flag-et a request-ben
        $request->attributes->set('watermark_enabled', config('watermark.enabled', true));

        return $next($request);
    }
}
