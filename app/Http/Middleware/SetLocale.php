<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\SwitchLocale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    public function __construct(private readonly SwitchLocale $switchLocale) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force English locale for specific routes
        if ($request->routeIs('en.properties.show', 'en.properties.show-for-sale', 'en.property.pdf')) {
            $this->switchLocale->handle('en');
        } elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
