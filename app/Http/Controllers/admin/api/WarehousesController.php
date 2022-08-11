<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Warehouses;

class WarehousesController extends Controller
{
    use ApiResponseHelpers;
    public function get()
    {
        $warehouses = Warehouses::all();
        return $this->respondWithSuccess(['warehouses' => $warehouses]);
    }
}
