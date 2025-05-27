<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');

/* Route::get('/', function () {
    return view('components.layouts.home');
}); */
