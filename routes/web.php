<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');
Route::view('/adatlap-oldal', 'index')->name('adatlap-oldal');
Route::view('/kiado-irodak', 'index')->name('kiado-irodak');
Route::view('/hirek', 'index')->name('hirek');
Route::view('/rolunk', 'index')->name('rolunk');
Route::view('/kapcsolat', 'index')->name('kapcsolat');

/* Route::get('/', function () {
    return view('components.layouts.home');
}); */
