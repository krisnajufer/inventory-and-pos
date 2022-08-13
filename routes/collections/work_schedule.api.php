<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\api\WorkSchedulesController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/work-schedule')->group(function () {
        Route::controller(WorkSchedulesController::class)->group(function () {
            Route::get('/get', 'get');
            Route::post('/post', 'post');
        });
    });
});
