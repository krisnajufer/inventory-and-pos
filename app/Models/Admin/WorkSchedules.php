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

    public function generateWorkScheduleId($work_place_id)
    {
        $date_now = Carbon::now();
    }
}
