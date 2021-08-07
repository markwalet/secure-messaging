<?php

use App\Http\Controllers\Api\ColleagueController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('colleagues', ColleagueController::class)->only(['index']);
});
