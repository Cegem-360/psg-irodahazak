<?php

declare(strict_types=1);

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'index')->name('adatlap-oldal');
Route::view('/kiado-irodak', 'index')->name('kiado-irodak');
Route::view('/elado-irodahazak', 'index')->name('elado-irodahazak');
Route::view('/rolunk', 'index')->name('rolunk');
Route::view('/kapcsolat', 'index')->name('kapcsolat');

// Legal pages
Route::view('/adatvedelmi-nyilatkozat', 'index')->name('privacy-policy');
Route::view('/impresszum', 'index')->name('impresszum');

// Contact form route
Route::post('/kapcsolat', [ContactController::class, 'store'])->name('contact.store');

// Test route for images
Route::view('/test-images', 'test-images')->name('test-images');

// Property routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/api/properties/{property}/images', [PropertyController::class, 'images'])->name('api.properties.images');
Route::get('/api/properties/{property}/images/{size}', [PropertyController::class, 'imagesWithSize'])->name('api.properties.images.size');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategoria/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// News routes
Route::get('/hirek', [NewsController::class, 'index'])->name('news.index');
Route::get('/hirek/kategoria/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/hirek/kereses', [NewsController::class, 'search'])->name('news.search');
Route::get('/hirek/{slug}', [NewsController::class, 'show'])->name('news.show');

/* Route::get('/', function () {
    return view('components.layouts.home');
}); */
