<?php

declare(strict_types=1);

use App\Actions\SwitchLocale;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImpresszumController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PropertyController;
use App\Models\Property;
use App\Services\FavoriteProperties;
use App\Services\FavoritesExcelExportService;
use App\Services\PropertyPdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Language switcher route
Route::get('/language/{locale}', function (string $locale, SwitchLocale $switchLocale): RedirectResponse {
    $switchLocale->handle($locale);

    return back();
})->whereIn('locale', ['hu', 'en'])->name('language.switch');

// Hungarian routes (default, no prefix)
Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'index')->name('adatlap-oldal');
Route::view('/kiado-irodak', 'index')->name('kiado-irodak');
Route::view('/elado-irodahazak', 'index')->name('elado-irodahazak');
Route::view('/rolunk', 'index')->name('rolunk');

Route::get('/kapcsolat', [ContactController::class, 'show'])->name('kapcsolat');

Route::view('/adatvedelmi-nyilatkozat', 'pages.privacy-policy')->name('privacy-policy');

Route::get('/impresszum', [ImpresszumController::class, 'show'])->name('impressum');

// Favorites are for signed-in users only, together with their Excel export
Route::middleware(['auth'])->group(function (): void {
    Route::view('/kedvencek', 'pages.favorites')->name('favorites');
    Route::get('/kedvencek/export-excel', fn (FavoriteProperties $favorites, FavoritesExcelExportService $export): StreamedResponse => $export->generate($favorites->properties()))->name('favorites.export-excel');
});

// Budapest irodaház kategória route-ok
Route::get('/budapest/{category}', [CategoryController::class, 'show'])->name('budapest.category');
Route::get('/login', function () {
    return to_route('filament.admin.auth.login'); // Redirect to the login page
})->name('login');
Route::get('/ingatlanok', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/kiado-iroda/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/elado-irodahaz/{property:slug}', [PropertyController::class, 'show'])->name('properties.show-for-sale');

Route::get('/hirek', [NewsController::class, 'index'])->name('news.index');
Route::get('/hirek/{slug}', [NewsController::class, 'show'])->name('news.show');

// English routes (different URLs, same functionality)
Route::group(['as' => 'en.'], function (): void {
    Route::view('/home', 'index')->name('home');
    Route::view('/data-sheet', 'index')->name('adatlap-oldal');
    Route::view('/offices-for-rent', 'index')->name('kiado-irodak');
    Route::view('/office-buildings-for-sale', 'index')->name('elado-irodahazak');
    Route::view('/about-us', 'index')->name('rolunk');
    Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy-policy');
    Route::get('/impressum', [ImpresszumController::class, 'show'])->name('impressum');
    Route::get('/contact-us', [ContactController::class, 'show'])->name('kapcsolat');

    // English Budapest category routes
    Route::get('/budapest-en/{category}', [CategoryController::class, 'show'])->name('budapest.category');

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/office-to-let/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/office-to-sale/{property:slug}', [PropertyController::class, 'show'])->name('properties.show-for-sale');
    Route::middleware(['auth'])->group(function (): void {
        Route::view('/favorites', 'pages.favorites')->name('favorites');
        Route::get('/favorites/export-excel', fn (FavoriteProperties $favorites, FavoritesExcelExportService $export): StreamedResponse => $export->generate($favorites->properties()))->name('favorites.export-excel');
    });
    Route::get('/news-blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/news-blog/category/{category:slug}', [BlogCategoryController::class, 'show'])->name('blog.category');
    Route::get('/news-blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
});

// IndexNow key file, served at the site root once INDEXNOW_KEY is set
Route::get('/{indexNowKey}.txt', function (string $indexNowKey): Response {
    $key = (string) config('seo.indexnow.key');

    abort_if($key === '' || ! hash_equals($key, $indexNowKey), 404);

    return response($key, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->where('indexNowKey', '[A-Za-z0-9-]{8,128}')->name('indexnow.key');

// PDF generation route for properties (protected by auth and signed URL)
Route::get('/property-pdf/{property}', function (Property $property): Response {
    $pdfService = new PropertyPdfService();

    return $pdfService->generatePdfForView($property);
})->name('property.pdf')->middleware(['signed']);
Route::get('/en/property-pdf/{property}', function (Property $property): Response {
    $pdfService = new PropertyPdfService();

    return $pdfService->generatePdfForView($property);
})->name('en.property.pdf')->middleware(['signed']);
