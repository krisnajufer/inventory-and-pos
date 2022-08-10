<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\UserController;
use App\Http\Controllers\Auth\UserAuthController;

Route::prefix('/auth')->group(function () {
    Route::controller(UserAuthController::class)->group(function () {
        Route::post('/login', 'Login');
        Route::post('/logout', 'Logout')->middleware('auth:sanctum');
    });
});
