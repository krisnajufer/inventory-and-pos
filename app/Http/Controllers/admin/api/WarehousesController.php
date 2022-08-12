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
use Exception;

class WarehousesController extends Controller
{
    use ApiResponseHelpers;
    public function get(): JsonResponse
    {
        $warehouses = Warehouses::all();
        return $this->respondWithSuccess(['warehouses' => $warehouses]);
    }

    public function post(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'warehouse_name' => 'required',
            'warehouse_address' => 'required',
            'warehouse_city' => 'required',
            'warehouse_status' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            $message = str_replace(array(
                '\'', '"',
                ',', '{', '[', ']', '}'
            ), '', $message);
            return $this->respondError($message);
        } else {
            $check_warehouse_name = Warehouses::where('warehouse_name', $request->warehouse_name)->first();
            $warehouse_id = Warehouses::generateWarehouseId();
            if (empty($check_warehouse_name)) {
                DB::beginTransaction();
                try {
                    $warehouses = new Warehouses();
                    $warehouses->warehouse_id = $warehouse_id;
                    $warehouses->slug = Str::random(16);
                    $warehouses->warehouse_name = $request->warehouse_name;
                    $warehouses->warehouse_address = $request->warehouse_address;
                    $warehouses->warehouse_city = $request->warehouse_city;
                    $warehouses->warehouse_status = $request->warehouse_status;

                    $warehouses->save();
                    DB::commit();
                    return $this->respondCreated(['warehouses' => $warehouses]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->respondError($e->getMessage());
                }
            } else {
                return $this->respondError("Warehouse Name already exist");
            }
        }
    }

    public function detail($slug): JsonResponse
    {
        $warehouses = Warehouses::where('slug', $slug)->first();
        if (!empty($warehouses)) {
            return $this->respondWithSuccess(['warehouses' => $warehouses]);
        } else {
            return $this->respondNotFound("Warehouse not found or not exist");
        }
    }

    public function update(Request $request, $slug): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'warehouse_name' => 'required',
            'warehouse_address' => 'required',
            'warehouse_city' => 'required',
            'warehouse_status' => 'required',
        ]);

        $warehouses = Warehouses::where('slug', $slug)->first();
        if (!empty($warehouses)) {
            if ($validator->fails()) {
                $message = $validator->errors();
                $message = str_replace(array(
                    '\'', '"',
                    ',', '{', '[', ']', '}'
                ), '', $message);
                return $this->respondError($message);
            } else {
                $check_warehouse_name = Warehouses::where('warehouse_name', $request->warehouse_name)
                    ->where('warehouse_name', '<>', $warehouses->warehouse_name)
                    ->first();
                if (empty($check_warehouse_name)) {
                    DB::beginTransaction();
                    try {
                        $warehouses->warehouse_name = $request->warehouse_name;
                        $warehouses->warehouse_address = $request->warehouse_address;
                        $warehouses->warehouse_city = $request->warehouse_city;
                        $warehouses->warehouse_status = $request->warehouse_status;

                        $warehouses->save();
                        DB::commit();
                        return $this->respondWithSuccess(['warehouses' => $warehouses]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                } else {
                    return $this->respondError("Warehouse Name already exist");
                }
            }
        } else {
            return $this->respondNotFound("Warehouse not found or not exist");
        }
    }

    public function delete($slug): JsonResponse
    {
        $warehouses = Warehouses::where('slug', $slug)->first();
        if (!empty($warehouses)) {
            DB::beginTransaction();
            try {
                $warehouses->delete();
                DB::commit();
                return $this->respondOk("Successfully deleted Warehouse");
            } catch (Exception $e) {
                DB::rollBack();
                return $this->respondError($e->getMessage());
            }
        } else {
            return $this->respondNotFound("Warehouse not found or not exist");
        }
    }
}
