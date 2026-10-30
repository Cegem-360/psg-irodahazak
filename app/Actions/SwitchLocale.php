<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * Switches the application locale for this request and remembers it in the
 * session for the following ones.
 */
final class SwitchLocale
{
    public function handle(string $locale): void
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
    }
}
