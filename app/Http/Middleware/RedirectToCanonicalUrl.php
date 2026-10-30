<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sends every request that arrives on a duplicate address of the site (http://,
 * www., or the /public/ prefix the hosting's document root exposes) to the same
 * path under APP_URL with a 301, so search engines index one URL per page.
 */
final class RedirectToCanonicalUrl
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->isProduction()) {
            return $next($request);
        }

        $appUrl = mb_rtrim((string) config('app.url'), '/');
        $canonicalScheme = parse_url($appUrl, PHP_URL_SCHEME);
        $canonicalHost = parse_url($appUrl, PHP_URL_HOST);

        // The hosting rewrites "/x" to "public/x", so a request for "/public/x"
        // reaches Laravel with "/public" as its base URL instead of an empty one.
        $isCanonical = $request->getScheme() === $canonicalScheme
            && $request->getHost() === $canonicalHost
            && $request->getBaseUrl() === '';

        if ($isCanonical || ! in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $queryString = $request->getQueryString();

        return redirect()->to($appUrl.$request->getPathInfo().($queryString ? '?'.$queryString : ''), 301);
    }
}
