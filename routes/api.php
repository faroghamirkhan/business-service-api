<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HealthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/health', [HealthController::class, 'index']);

    Route::post('/auth/register', [AuthController::class, 'register']);

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});