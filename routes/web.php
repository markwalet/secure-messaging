<?php

use App\Http\Controllers\DecryptMessageController;
use App\Http\Controllers\MessageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('messages', MessageController::class)->only(['create', 'store'])->middleware('auth:sanctum');
Route::resource('messages', MessageController::class)->only(['show'])->middleware('signed');
Route::post('messages/{message}', DecryptMessageController::class)
    ->middleware('signed')
    ->name('decrypt-message');
