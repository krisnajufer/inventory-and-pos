<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\api\EmployeeController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/employee')->group(function () {
        Route::controller(EmployeeController::class)->group(function () {
            Route::get('/get', 'get');
            Route::post('/post', 'post');
            Route::get('/detail/{slug}', 'detail');
            Route::put('/update/{slug}', 'update');
            Route::delete('/delete/{slug}', 'delete');
        });
    });
});
