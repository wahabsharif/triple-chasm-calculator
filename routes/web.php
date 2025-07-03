<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClearCacheController;


Route::get('/', function () {
    return view('home');
});

Route::get('/clear', [ClearCacheController::class, 'clearAll']);
