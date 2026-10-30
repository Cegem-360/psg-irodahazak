<?php

declare(strict_types=1);

use App\Http\Middleware\RedirectToCanonicalUrl;
use App\Http\Middleware\SetLocale;
use App\Services\FavoriteProperties;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\GoogleTagManager\GoogleTagManagerMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(RedirectToCanonicalUrl::class);

        // The browser reads and writes the favorites list too, so it stays plain JSON.
        $middleware->encryptCookies(except: [FavoriteProperties::COOKIE]);

        $middleware->web(append: [
            SetLocale::class,
            GoogleTagManagerMiddleware::class,
        ]);

        // Register middleware aliases
        $middleware->alias([
            'signed' => Illuminate\Routing\Middleware\ValidateSignature::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
