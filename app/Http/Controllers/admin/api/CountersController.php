<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Counters;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CountersController extends Controller
{
    use ApiResponseHelpers;
    public function get(): JsonResponse
    {
        $counters = Counters::all();
        return $this->respondWithSuccess(['counters' => $counters]);
    }

    public function validatorHelper($request)
    {
        $validator = Validator::make($request, [
            'counter_name' => 'required',
            'counter_address' => 'required',
            'counter_city' => 'required',
            'counter_status' => 'required',
        ]);

        return $validator;
    }
}
