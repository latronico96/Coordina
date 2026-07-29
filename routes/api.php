<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function () {
        return auth()->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

});
