<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClearCacheController;
use App\Http\Controllers\ProfileController;


use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/questionnaire', function () {
    return view('questionnaire');
});
Route::get('/help', function () {
    return view('help');
});

Route::get('/clear', [ClearCacheController::class, 'clearAll']);


// Profile routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
