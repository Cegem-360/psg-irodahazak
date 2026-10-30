<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\SwitchLocale;
use App\Services\LocalizedRoutes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    public function __construct(
        private readonly SwitchLocale $switchLocale,
        private readonly LocalizedRoutes $localizedRoutes,
    ) {}

    /**
     * A page that exists in both languages is shown in the language of its URL,
     * so search engines see one language per address; the choice is kept in the
     * session for the requests that have no language of their own (Livewire
     * updates, the blog, the login).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->localizedRoutes->localeOf($request->route());

        if ($locale !== null) {
            $this->switchLocale->handle($locale);
        } elseif (in_array(Session::get('locale'), LocalizedRoutes::LOCALES, true)) {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
