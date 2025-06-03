<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'adatlap')->name('adatlap-oldal');

/* Route::get('/', function () {
    return view('components.layouts.home');
}); */
