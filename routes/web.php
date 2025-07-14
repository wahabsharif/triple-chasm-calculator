<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClearCacheController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\DashboardController;


use App\Http\Controllers\PasswordController;

// Password check routes (must be accessible without password)
Route::get('/password-check', [PasswordController::class, 'showForm'])->name('password.form');
Route::post('/password-check', [PasswordController::class, 'check'])->name('password.check');

// All other routes require password
Route::middleware('password.protect')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
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
});
