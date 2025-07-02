<?php

declare(strict_types=1);

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImpresszumController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PropertyController;
use App\Models\Property;
use App\Services\PropertyPdfService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Language switcher route
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Hungarian routes (default, no prefix)
Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'index')->name('adatlap-oldal');
Route::view('/kiado-irodak', 'index')->name('kiado-irodak');
Route::view('/elado-irodahazak', 'index')->name('elado-irodahazak');
Route::view('/rolunk', 'index')->name('rolunk');

Route::view('/kapcsolat', 'index')->name('kapcsolat');
Route::view('/adatvedelmi-nyilatkozat', 'index')->name('privacy-policy');
Route::get('/impresszum', [ImpresszumController::class, 'show'])->name('impresszum');
Route::post('/kapcsolat', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth'])->group(function (): void {
    Route::view('/kedvencek', 'pages.favorites')->name('favorites');
});

// Budapest irodaház kategória route-ok
Route::get('/budapest/{category}', function ($category) {
    $queryParams = [];
    $queryParams['category'] = $category;

    if ($category === 'elado-irodak') {
        return redirect()->route('elado-irodahazak');
    }

    return view('pages.filter', ['queryParams' => $queryParams]);
})->name('budapest.category');
Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login'); // Redirect to the login page
})->name('login');
Route::get('/ingatlanok', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/kiado-iroda/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/elado-irodahaz/{property:slug}', [PropertyController::class, 'show'])->name('properties.show-for-sale');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategoria/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/hirek', [NewsController::class, 'index'])->name('news.index');
Route::get('/hirek/{slug}', [NewsController::class, 'show'])->name('news.show');

// English routes (different URLs, same functionality)
Route::group(['as' => 'en.'], function (): void {
    Route::view('/contact', 'index')->name('home');
    Route::view('/data-sheet', 'index')->name('adatlap-oldal');
    Route::view('/offices-for-rent', 'index')->name('kiado-irodak');
    Route::view('/office-buildings-for-sale', 'index')->name('elado-irodahazak');
    Route::view('/about-us', 'index')->name('rolunk');
    Route::view('/contact-us', 'index')->name('kapcsolat');
    Route::view('/privacy-policy', 'index')->name('privacy-policy');
    Route::view('/impressum', 'index')->name('impresszum');
    Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

    // English Budapest category routes
    Route::get('/budapest-en/{category}', function ($category) {
        $queryParams = [];

        // District-based filtering (same logic as Hungarian)
        switch ($category) {
            case 'kiado-pesti-irodak':
                $queryParams['districts'] = '4,5,6,7,8,9,10,14,15,16,17,18,19,20';
                break;
            case 'kiado-belvarosi-irodak':
                $queryParams['districts'] = '5,6,7,8,9';
                break;
            case 'kiado-v-keruleti-irodak':
                $queryParams['districts'] = '5';
                break;
            case 'kiado-vaci-uti-irodak':
                $queryParams['districts'] = '13,14';
                break;
            case 'kiado-budai-irodak':
                $queryParams['districts'] = '1,2,3,11,12,22';
                break;
            case 'kiado-bel-budai-irodak':
                $queryParams['districts'] = '1,2,11,12';
                break;
            case 'kiado-xi-keruleti-irodak':
                $queryParams['districts'] = '11';
                break;
            case 'kiado-azonnali-szolgaltatott-irodak':
                $queryParams['search'] = 'szolgáltatott';
                break;
            case 'kiado-zold-irodak':
                $queryParams['search'] = 'zöld';
                break;
            case 'kiado-klasszikus-irodahazak':
                $queryParams['search'] = 'klasszikus';
                break;
            case 'kiado-uj-irodahazak':
                $queryParams['search'] = 'új';
                break;
            case 'elado-irodak':
                return redirect()->route('en.elado-irodahazak');
            default:
                // If no match, redirect to English home
                return redirect()->route('en.kiado-irodak');
        }

        return view('pages.filter', ['queryParams' => $queryParams]);
    })->name('budapest.category');

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');
    Route::view('/favorites', 'pages.favorites')->name('favorites');
    Route::get('/news-blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/news-blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/news-blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
});

// Test route for PDF generation (remove in production)
Route::get('/test-pdf/{property}', function (Property $property): StreamedResponse {
    $pdfService = new PropertyPdfService();

    return $pdfService->generatePdf($property);
})->name('test.pdf');

// PDF generation route for properties
Route::get('/property-pdf/{property}', function (Property $property): Response {
    $pdfService = new PropertyPdfService();

    return $pdfService->generatePdfForView($property);
})->name('property.pdf');

// PDF preview route (HTML only, no PDF generation)
Route::get('/property-preview/{property}', function (Property $property) {
    return view('pdf.property', ['property' => $property]);
})->name('property.preview');
