<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClearCacheController;


Route::get('/', function () {
    return view('dashboard');
});
Route::get('/profile', function () {
    return view('profile');
});

Route::get('/clear', [ClearCacheController::class, 'clearAll']);
