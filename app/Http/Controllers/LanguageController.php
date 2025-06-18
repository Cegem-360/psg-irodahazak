<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

final class LanguageController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switch(Request $request, string $locale)
    {
        // Check if the locale is supported
        if (! in_array($locale, ['hu', 'en'])) {
            abort(404);
        }

        // Store the locale in session
        Session::put('locale', $locale);

        // Redirect to the equivalent page in the new language
        $targetUrl = switch_locale_route($locale);

        return redirect($targetUrl);
    }
}
