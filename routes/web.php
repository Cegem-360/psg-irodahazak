<?php

declare(strict_types=1);

use App\Actions\ExportFavorites;
use App\Actions\PrintProperty;
use App\Actions\SwitchLocale;
use App\Livewire\Pages;
use App\Livewire\Pages\Company\About;
use App\Livewire\Pages\Company\Contact;
use App\Livewire\Pages\Company\Founder;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Legal\Impressum;
use App\Livewire\Pages\Legal\PrivacyPolicy;
use App\Livewire\Pages\Office\Category;
use App\Livewire\Pages\Office\ForRent;
use App\Livewire\Pages\Office\ForSale;
use App\Livewire\Pages\Office\RentalFees;
use App\Livewire\Pages\Property\DataSheet;
use App\Livewire\Pages\Property\Favorites;
use App\Livewire\Pages\Property\Index;
use App\Livewire\Pages\Property\Show;
use App\Models\PropertyRedirect;
use App\Services\LocalizedRoutes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Every public page is a full-page Livewire component (App\Livewire\Pages)
| and exists twice: under a Hungarian URL, and under an English one whose
| route name carries the "en." prefix. The two blocks below mirror each
| other line by line. The URL decides the language of the page (see
| App\Services\LocalizedRoutes), so a new page needs a route in both blocks.
|
| A property page outlives its listing: an inactive or deleted property still
| answers (withTrashed), as a data sheet without fees; one deleted for good
| redirects to its district's page.
|
*/

$redirectDeletedProperty = function (Request $request): RedirectResponse {
    $redirect = PropertyRedirect::query()->where('slug', $request->route('property'))->firstOrFail();

    // Runs while the route bindings are resolved, before SetLocale: the target is in the URL's language
    app()->setLocale(resolve(LocalizedRoutes::class)->localeOf($request->route()) ?? LocalizedRoutes::DEFAULT_LOCALE);

    return redirect()->to($redirect->targetUrl(), 301);
};

/*
|--------------------------------------------------------------------------
| Hungarian site
|--------------------------------------------------------------------------
*/

// Pages
Route::livewire('/', Home::class)->name('home');
Route::livewire('/kiado-irodak', ForRent::class)->name('kiado-irodak');
Route::livewire('/elado-irodahazak', ForSale::class)->name('elado-irodahazak');
Route::livewire('/rolunk', About::class)->name('rolunk');
Route::livewire('/adatlap-oldal', DataSheet::class)->name('adatlap-oldal');
Route::livewire('/adatvedelmi-nyilatkozat', PrivacyPolicy::class)->name('privacy-policy');
Route::livewire('/kapcsolat', Contact::class)->name('kapcsolat');
Route::livewire('/impresszum', Impressum::class)->name('impressum');

// Hungarian-only pages (no English twin)
Route::livewire('/fekete-richard', Founder::class)->name('fekete-richard');
Route::livewire('/budapest/irodaberleti-dijak', RentalFees::class)->name('rental-fees');

// Office categories (the old "for sale" category is the sale list itself)
Route::permanentRedirect('/budapest/elado-irodak', '/elado-irodahazak');
Route::livewire('/budapest/{category:slug}', Category::class)->name('budapest.category');

// Properties
Route::livewire('/ingatlanok', Index::class)->name('properties.index');
Route::livewire('/kiado-iroda/{property:slug}', Show::class)->name('properties.show')
    ->withTrashed()->missing($redirectDeletedProperty);
Route::livewire('/elado-irodahaz/{property:slug}', Show::class)->name('properties.show-for-sale')
    ->withTrashed()->missing($redirectDeletedProperty);

// News
Route::livewire('/hirek', Pages\News\Index::class)->name('news.index');
Route::livewire('/hirek/{news:slug}', Pages\News\Show::class)->name('news.show');

// Favorites (signed-in users only)
Route::middleware('auth')->group(function (): void {
    Route::livewire('/kedvencek', Favorites::class)->name('favorites');
    Route::get('/kedvencek/export-excel', ExportFavorites::class)->name('favorites.export-excel');
});

/*
|--------------------------------------------------------------------------
| English site
|--------------------------------------------------------------------------
*/

Route::name('en.')->group(function () use ($redirectDeletedProperty): void {
    // Pages
    Route::livewire('/home', Home::class)->name('home');
    Route::livewire('/offices-for-rent', ForRent::class)->name('kiado-irodak');
    Route::livewire('/office-buildings-for-sale', ForSale::class)->name('elado-irodahazak');
    Route::livewire('/about-us', About::class)->name('rolunk');
    Route::livewire('/data-sheet', DataSheet::class)->name('adatlap-oldal');
    Route::livewire('/privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
    Route::livewire('/contact-us', Contact::class)->name('kapcsolat');
    Route::livewire('/impressum', Impressum::class)->name('impressum');

    // Office categories
    Route::permanentRedirect('/budapest-en/elado-irodak', '/office-buildings-for-sale');
    Route::livewire('/budapest-en/{category:slug}', Category::class)->name('budapest.category');

    // Properties
    Route::livewire('/properties', Index::class)->name('properties.index');
    Route::livewire('/office-to-let/{property:slug}', Show::class)->name('properties.show')
        ->withTrashed()->missing($redirectDeletedProperty);
    Route::livewire('/office-to-sale/{property:slug}', Show::class)->name('properties.show-for-sale')
        ->withTrashed()->missing($redirectDeletedProperty);

    // News
    Route::livewire('/news', Pages\News\Index::class)->name('news.index');
    Route::livewire('/news/{news:slug}', Pages\News\Show::class)->name('news.show');

    // Blog (no list page of its own: the latest posts are on the home page)
    Route::redirect('/news-blog', '/')->name('blog.index');
    Route::livewire('/news-blog/category/{category:slug}', Pages\Blog\Category::class)->name('blog.category');
    Route::livewire('/news-blog/{post:slug}', Pages\Blog\Show::class)->name('blog.show');

    // Favorites (signed-in users only)
    Route::middleware('auth')->group(function (): void {
        Route::livewire('/favorites', Favorites::class)->name('favorites');
        Route::get('/favorites/export-excel', ExportFavorites::class)->name('favorites.export-excel');
    });
});

/*
|--------------------------------------------------------------------------
| Printable property sheet
|--------------------------------------------------------------------------
|
| The links are signed, and every request starts a headless Chrome, hence
| the rate limit.
|
*/

Route::middleware(['signed', 'throttle:20,1'])->group(function (): void {
    Route::get('/property-pdf/{property}', PrintProperty::class)->name('property.pdf');
    Route::get('/en/property-pdf/{property}', PrintProperty::class)->name('en.property.pdf');
});

/*
|--------------------------------------------------------------------------
| Utility routes
|--------------------------------------------------------------------------
*/

// Language switcher for pages without a twin in the other language (the blog, the login)
Route::get('/language/{locale}', function (string $locale, SwitchLocale $switchLocale): RedirectResponse {
    $switchLocale->handle($locale);

    return back();
})->whereIn('locale', LocalizedRoutes::LOCALES)->name('language.switch');

Route::redirect('/login', '/admin/login')->name('login');

// IndexNow key file, served at the site root once INDEXNOW_KEY is set
Route::get('/{indexNowKey}.txt', function (string $indexNowKey): Response {
    $key = (string) config('seo.indexnow.key');

    abort_if($key === '' || ! hash_equals($key, $indexNowKey), 404);

    return response($key, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->where('indexNowKey', '[A-Za-z0-9-]{8,128}')->name('indexnow.key');
