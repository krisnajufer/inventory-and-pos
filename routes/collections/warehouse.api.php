<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\api\WarehousesController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/warehouse')->group(function () {
        Route::controller(WarehousesController::class)->group(function () {
            Route::get('/get', 'get');
            Route::post('/post', 'post');
            Route::get('/detail/{slug}', 'detail');
        });
    });
});
