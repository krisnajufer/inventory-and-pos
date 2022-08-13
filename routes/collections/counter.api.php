<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\api\CountersController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/counter')->group(function () {
        Route::controller(CountersController::class)->group(function () {
            Route::get('/get', 'get');
            Route::post('/post', 'post');
            Route::get('/detail/{slug}', 'detail');
            Route::put('/update/{slug}', 'update');
            Route::delete('/delete/{slug}', 'delete');
        });
    });
});
