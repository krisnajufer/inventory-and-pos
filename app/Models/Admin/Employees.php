<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id', 'slug',
        'user_id', 'first_name',
        'last_name', 'employee_address',
        'employee_city', 'date_of_birth',
        'gender', 'phone_number', 'role'
    ];

    public static function generateEmployeeId()
    {
        $employee_id = DB::table('employees')->max('employee_id');
        $add_zero = "";
        $employee_id = str_replace("E", "", $employee_id);
        $employee_id = (int) $employee_id + 1;
        $increment_employee_id = $employee_id;

        if (strlen($employee_id) == 1) {
            $add_zero = "000";
        } elseif (strlen($employee_id) == 2) {
            $add_zero = "00";
        } elseif (strlen($employee_id) == 3) {
            $add_zero = "0";
        }

        $new_employee_id = "E" . $add_zero . $increment_employee_id;
        return $new_employee_id;
    }
}
