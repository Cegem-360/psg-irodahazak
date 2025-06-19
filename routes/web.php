<?php

declare(strict_types=1);

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

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
Route::view('/impresszum', 'index')->name('impresszum');
Route::post('/kapcsolat', [ContactController::class, 'store'])->name('contact.store');

// Budapest irodaház kategória route-ok
Route::get('/budapest/{category}', function ($category) {
    $districtsMap = [
        'kiado-azonnali-szolgaltatott-irodak' => '',
        'kiado-pesti-irodak' => 'IV. kerület,V. kerület,VI. kerület,VII. kerület,VIII. kerület,IX. kerület,X. kerület,XIV. kerület,XV. kerület,XVI. kerület,XVII. kerület,XVIII. kerület,XIX. kerület,XX. kerület',
        'kiado-belvarosi-irodak' => 'V. kerület,VI. kerület,VII. kerület,VIII. kerület,IX. kerület',
        'kiado-v-keruleti-irodak' => 'V. kerület',
        'kiado-vaci-uti-irodak' => 'XIII. kerület,XIV. kerület',
        'kiado-budai-irodak' => 'I. kerület,II. kerület,III. kerület,XI. kerület,XII. kerület,XXII. kerület',
        'kiado-bel-budai-irodak' => 'I. kerület,II. kerület,XI. kerület,XII. kerület',
        'kiado-xi-keruleti-irodak' => 'XI. kerület',
        'kiado-zold-irodak' => '',
        'kiado-klasszikus-irodahazak' => '',
        'kiado-uj-irodahazak' => '',
        'elado-irodak' => '',
    ];

    $districts = $districtsMap[$category] ?? '';
    $queryParams = [];

    if ($districts) {
        $queryParams['districts'] = $districts;
    }

    // Speciális szűrők
    if ($category === 'kiado-azonnali-szolgaltatott-irodak') {
        $queryParams['search'] = 'szolgáltatott';
    } elseif ($category === 'kiado-zold-irodak') {
        $queryParams['search'] = 'zöld';
    } elseif ($category === 'kiado-klasszikus-irodahazak') {
        $queryParams['search'] = 'klasszikus';
    } elseif ($category === 'kiado-uj-irodahazak') {
        $queryParams['search'] = 'új';
    } elseif ($category === 'elado-irodak') {
        return redirect()->route('elado-irodahazak');
    }

    return redirect()->route('kiado-irodak', $queryParams);
})->name('budapest.category');

Route::get('/ingatlanok', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/ingatlanok/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategoria/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/hirek', [NewsController::class, 'index'])->name('news.index');
Route::get('/hirek/kategoria/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/hirek/kereses', [NewsController::class, 'search'])->name('news.search');
Route::get('/hirek/{slug}', [NewsController::class, 'show'])->name('news.show');

// English routes (different URLs, same functionality)
Route::group(['as' => 'en.'], function () {
    Route::view('/contact', 'index')->name('home');
    Route::view('/data-sheet', 'index')->name('adatlap-oldal');
    Route::view('/offices-for-rent', 'index')->name('kiado-irodak');
    Route::view('/office-buildings-for-sale', 'index')->name('elado-irodahazak');
    Route::view('/about-us', 'index')->name('rolunk');
    Route::view('/contact-us', 'index')->name('kapcsolat');
    Route::view('/privacy-policy', 'index')->name('privacy-policy');
    Route::view('/impressum', 'index')->name('impresszum');
    Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/news-blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/news-blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/news-blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/category/{slug}', [NewsController::class, 'category'])->name('news.category');
    Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
});

// API routes (not localized)
Route::get('/api/properties/{property}/images', [PropertyController::class, 'images'])->name('api.properties.images');
Route::get('/api/properties/{property}/images/{size}', [PropertyController::class, 'imagesWithSize'])->name('api.properties.images.size');
Route::get('/api/search-office-names', [PropertyController::class, 'searchOfficeNames'])->name('api.search.office.names');
