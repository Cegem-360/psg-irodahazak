<?php

declare(strict_types=1);

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'index')->name('adatlap-oldal');
Route::view('/kiado-irodak', 'index')->name('kiado-irodak');
Route::view('/hirek', 'index')->name('hirek');
Route::view('/rolunk', 'index')->name('rolunk');
Route::view('/kapcsolat', 'index')->name('kapcsolat');

// Test route for images
Route::view('/test-images', 'test-images')->name('test-images');

// Property routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/api/properties/{property}/images', [PropertyController::class, 'images'])->name('api.properties.images');
Route::get('/api/properties/{property}/images/{size}', [PropertyController::class, 'imagesWithSize'])->name('api.properties.images.size');

/* Route::get('/', function () {
    return view('components.layouts.home');
}); */
