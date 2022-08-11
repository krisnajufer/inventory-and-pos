<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\UserController;

Route::middleware('auth:sanctum')->group(function () {

    // Route API users
    Route::prefix('/user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get', 'get');
            Route::post('/post', 'post');
            Route::put('/update/{slug}', 'update');
            Route::get('/detail/{slug}', 'detail');
            Route::delete('/delete/{slug}', 'delete');
        });
    });
    // End of Route API users

});
