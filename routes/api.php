<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require __DIR__ . '/collections/auth.api.php';
require __DIR__ . '/collections/user.api.php';
require __DIR__ . '/collections/employee.api.php';
require __DIR__ . '/collections/warehouse.api.php';
require __DIR__ . '/collections/counter.api.php';

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
