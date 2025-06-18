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

// Default (Hungarian) routes
Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'index')->name('adatlap-oldal');
Route::view('/kiado-irodak', 'index')->name('kiado-irodak');
Route::view('/elado-irodahazak', 'index')->name('elado-irodahazak');
Route::view('/rolunk', 'index')->name('rolunk');
Route::view('/kapcsolat', 'index')->name('kapcsolat');
Route::view('/adatvedelmi-nyilatkozat', 'index')->name('privacy-policy');
Route::view('/impresszum', 'index')->name('impresszum');
Route::post('/kapcsolat', [ContactController::class, 'store'])->name('contact.store');

// Hungarian content routes
Route::get('/ingatlanok', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/ingatlanok/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategoria/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/hirek', [NewsController::class, 'index'])->name('news.index');
Route::get('/hirek/kategoria/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/hirek/kereses', [NewsController::class, 'search'])->name('news.search');
Route::get('/hirek/{slug}', [NewsController::class, 'show'])->name('news.show');

// English routes
Route::prefix('en')->group(function () {
    Route::view('/', 'index')->name('en.home');
    Route::view('/data-sheet', 'index')->name('en.adatlap-oldal');
    Route::view('/offices-for-rent', 'index')->name('en.kiado-irodak');
    Route::view('/office-buildings-for-sale', 'index')->name('en.elado-irodahazak');
    Route::view('/about-us', 'index')->name('en.rolunk');
    Route::view('/contact', 'index')->name('en.kapcsolat');
    Route::view('/privacy-policy', 'index')->name('en.privacy-policy');
    Route::view('/impressum', 'index')->name('en.impresszum');
    Route::post('/contact', [ContactController::class, 'store'])->name('en.contact.store');

    // English content routes
    Route::get('/properties', [PropertyController::class, 'index'])->name('en.properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('en.properties.show');
    Route::get('/blog', [BlogController::class, 'index'])->name('en.blog.index');
    Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('en.blog.category');
    Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('en.blog.show');
    Route::get('/news', [NewsController::class, 'index'])->name('en.news.index');
    Route::get('/news/category/{slug}', [NewsController::class, 'category'])->name('en.news.category');
    Route::get('/news/search', [NewsController::class, 'search'])->name('en.news.search');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('en.news.show');
});

// API routes (not localized)
Route::get('/api/properties/{property}/images', [PropertyController::class, 'images'])->name('api.properties.images');
Route::get('/api/properties/{property}/images/{size}', [PropertyController::class, 'imagesWithSize'])->name('api.properties.images.size');

// Test route for images
Route::view('/test-images', 'test-images')->name('test-images');

/* Route::get('/', function () {
    return view('components.layouts.home');
}); */
