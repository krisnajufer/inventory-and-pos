<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\WorkSchedules;

class WorkSchedulesController extends Controller
{
    use ApiResponseHelpers;
    public function get(): JsonResponse
    {
        $work_schedules = WorkSchedules::select('work_schedules.work_schedule_id', 'work_schedules.slug', DB::raw("CONCAT(e.firstname,' ',e.lastname) AS fullname"), "w.warehouse_name", "c.counter_name", 'work_schedules.working_date')
            ->leftjoin('employees as e', 'work_schedules.employee_id', '=', 'e.employee_id')
            ->leftjoin('warehouses as w', 'work_schedules.warehouse_id', '=', 'w.warehouse_id')
            ->leftjoin('counters as c', 'work_schedules.counter_id', '=', 'c.counter_id')
            ->get();

        return $this->respondWithSuccess(['work_schedules' => $work_schedules]);
    }

    public function validatorHelper($request)
    {
        $validator = Validator::make($request, [
            'employee_id' => 'required',
            'work_place_id' => 'required',
            'working_date' => 'required'
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
            $word = substr($request->work_place_id, 0, 1);
            $work_schedule_id = WorkSchedules::generateWorkScheduleId($request->work_place_id);
            $check_available = WorkSchedules::where(['employee_id' => $request->employee_id, 'working_date' => $request->working_date])->first();
            if (!empty($check_available)) {
                return $this->respondError("Employee already has a work schedule on that date");
            } else {
                if ($word == 'W') {
                    DB::beginTransaction();
                    try {
                        $work_schedules = new WorkSchedules();
                        $work_schedules->work_schedule_id = $work_schedule_id;
                        $work_schedules->slug = Str::random(16);
                        $work_schedules->employee_id = $request->employee_id;
                        $work_schedules->warehouse_id = $request->work_place_id;
                        $work_schedules->working_date = $request->working_date;

                        $work_schedules->save();
                        DB::commit();
                        return $this->respondCreated(['work_schedules' => $work_schedules]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                } else {
                    DB::beginTransaction();
                    try {
                        $work_schedules = new WorkSchedules();
                        $work_schedules->work_schedule_id = $work_schedule_id;
                        $work_schedules->slug = Str::random(16);
                        $work_schedules->employee_id = $request->employee_id;
                        $work_schedules->counter_id = $request->work_place_id;
                        $work_schedules->working_date = $request->working_date;

                        $work_schedules->save();
                        DB::commit();
                        return $this->respondCreated(['work_schedules' => $work_schedules]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                }
            }
        }
    }

    public function update(Request $request, $slug): JsonResponse
    {
        $validator = $this->validatorHelper($request->all());

        $work_schedules = WorkSchedules::where('slug', $slug)->first();

        if ($validator->fails()) {
            $message = $validator->errors();
            $message = str_replace(array(
                '\'', '"',
                ',', '{', '[', ']', '}'
            ), '', $message);
            return $this->respondError($message);
        } else {
            if (!empty($work_schedules)) {
                $word = substr($request->work_place_id, 0, 1);
                if ($word == 'W') {
                    DB::beginTransaction();
                    try {
                        $work_schedules->employee_id = $request->employee_id;
                        $work_schedules->warehouse_id = $request->work_place_id;
                        $work_schedules->counter_id = NULL;
                        $work_schedules->working_date = $request->working_date;

                        $work_schedules->save();
                        DB::commit();
                        return $this->respondWithSuccess(['work_schedules' => $work_schedules]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                } else {
                    DB::beginTransaction();
                    try {
                        $work_schedules->employee_id = $request->employee_id;
                        $work_schedules->counter_id = $request->work_place_id;
                        $work_schedules->warehouse_id = NULL;
                        $work_schedules->working_date = $request->working_date;

                        $work_schedules->save();
                        DB::commit();
                        return $this->respondWithSuccess(['work_schedules' => $work_schedules]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                }
            } else {
                return $this->respondError("Work Schedule not found or not exist");
            }
        }
    }
}
