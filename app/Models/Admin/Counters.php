<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Counters extends Model
{
    use HasFactory;

    protected $table = 'counters';
    protected $primaryKey = 'counter_id';
    protected $keyType = 'string';

    protected $fillable = [
        'counter_id', 'slug', 'counter_name',
        'counter_address', 'counter_city', 'counter_status'
    ];

    public static function generateCounterId()
    {
        $counter_id = DB::table('counters')->max('counter_id');
        $add_zero = "";
        $counter_id = str_replace("C", "", $counter_id);
        $counter_id = (int) $counter_id + 1;
        $increment_counter_id = $counter_id;

        if (strlen($counter_id) == 1) {
            $add_zero = "000";
        } elseif (strlen($counter_id) == 2) {
            $add_zero = "00";
        } elseif (strlen($counter_id) == 3) {
            $add_zero = "0";
        }

        $new_counter_id = "C" . $add_zero . $increment_counter_id;
        return $new_counter_id;
    }
}
