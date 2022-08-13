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

    public function post(Request $request): JsonResponse
    {
        $validator = $this->validatorHelper($request->all());

        if ($validator->fails()) {
            $message = $validator->errors();
            $message = str_replace(array(
                '\'', '"',
                ',', '{', '[', ']', '}'
            ), '', $message);
            return $this->respondError($message);
        } else {
            $check_counter_name = Counters::where('counter_name', $request->counter_name)->first();
            $counter_id = Counters::generatecounterId();
            if (empty($check_counter_name)) {
                DB::beginTransaction();
                try {
                    $counters = new Counters();
                    $counters->counter_id = $counter_id;
                    $counters->slug = Str::random(16);
                    $counters->counter_name = $request->counter_name;
                    $counters->counter_address = $request->counter_address;
                    $counters->counter_city = $request->counter_city;
                    $counters->counter_status = $request->counter_status;

                    $counters->save();
                    DB::commit();
                    return $this->respondCreated(['counters' => $counters]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->respondError($e->getMessage());
                }
            } else {
                return $this->respondError("Counter Name already exist");
            }
        }
    }

    public function detail($slug): JsonResponse
    {
        $counters = Counters::where('slug', $slug)->first();
        if (!empty($counters)) {
            return $this->respondWithSuccess(['counters' => $counters]);
        } else {
            return $this->respondNotFound("Counter not found or not exist");
        }
    }

    public function update(Request $request, $slug): JsonResponse
    {
        // $request_all = $request->all();
        $validator = $this->validatorHelper($request->all());

        $counters = Counters::where('slug', $slug)->first();
        if (!empty($counters)) {
            if ($validator->fails()) {
                $message = $validator->errors();
                $message = str_replace(array(
                    '\'', '"',
                    ',', '{', '[', ']', '}'
                ), '', $message);
                return $this->respondError($message);
            } else {
                $check_counter_name = Counters::where('counter_name', $request->counter_name)
                    ->where('counter_name', '<>', $counters->counter_name)
                    ->first();
                if (empty($check_counter_name)) {
                    DB::beginTransaction();
                    try {
                        $counters->counter_name = $request->counter_name;
                        $counters->counter_address = $request->counter_address;
                        $counters->counter_city = $request->counter_city;
                        $counters->counter_status = $request->counter_status;

                        $counters->save();
                        DB::commit();
                        return $this->respondWithSuccess(['counters' => $counters]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                } else {
                    return $this->respondError("Counter Name already exist");
                }
            }
        } else {
            return $this->respondNotFound("Counter not found or not exist");
        }
    }

    public function delete($slug): JsonResponse
    {
        $counters = Counters::where('slug', $slug)->first();
        if (!empty($counters)) {
            DB::beginTransaction();
            try {
                $counters->delete();
                DB::commit();
                return $this->respondOk("Successfully deleted counter");
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->respondError($e->getMessage());
            }
        } else {
            return $this->respondNotFound("Counter not found or not exist");
        }
    }
}
