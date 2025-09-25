<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

final class LanguageController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switch(Request $request, string $locale)
    {
        if ($request->routeIs('en.properties.show', 'en.properties.show-for-sale', 'en.property.pdf')) {
            App::setLocale('en');
            Session::put('locale', 'en');

            return redirect()->back();
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return redirect()->back();
    }
}
