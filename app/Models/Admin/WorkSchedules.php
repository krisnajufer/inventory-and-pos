<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WorkSchedules extends Model
{
    use HasFactory;

    protected $table = 'work_schedules';
    protected $primaryKey = 'work_schedule_id';
    protected $keyType = 'string';

    protected $fillable = [
        'work_schedule_id', 'employee_id', 'warehouse_id',
        'counter_id', 'working_date'
    ];

    public static function generateWorkScheduleId($work_place_id)
    {
        $date_now = Carbon::now();
        $year = date('Y', strtotime($date_now));

        $query = "SELECT MAX(work_schedule_id) as max from work_schedules where substr(work_schedule_id, 10,4) = '" . $year . "' and substr(work_schedule_id, 4,5) = '" . $work_place_id . "'";
        $datas = DB::select($query);

        foreach ($datas as $data) {
            $max = $data->max;
        }

        $add_zero = '';
        $past_work_schedule_id = substr($max, 15, 6);
        $past_work_schedule_id = (int)$past_work_schedule_id + 1;
        $increment_id = $past_work_schedule_id;

        if (strlen($past_work_schedule_id) == 1) {
            $add_zero = "0000";
        } elseif (strlen($past_work_schedule_id) == 2) {
            $add_zero = "000";
        } elseif (strlen($past_work_schedule_id) == 3) {
            $add_zero = "00";
        } elseif (strlen($past_work_schedule_id) == 4) {
            $add_zero = "0";
        }

        $new_work_schedule_id = "WS" . '.' . $work_place_id . '.' . $year . '.' . $add_zero . $increment_id;

        return $new_work_schedule_id;
    }
}
