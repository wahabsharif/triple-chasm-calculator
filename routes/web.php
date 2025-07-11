<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClearCacheController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', function () {
    return view('profile');
});


// Questionnaire routes
Route::get('/questionnaire', [QuestionnaireController::class, 'show'])->name('questionnaire.show');
Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');

Route::get('/help', function () {
    return view('help');
});

Route::get('/clear', [ClearCacheController::class, 'clearAll']);


// Profile routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
