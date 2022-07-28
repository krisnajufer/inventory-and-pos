<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Warehouses extends Model
{
    use HasFactory;

    protected $table = 'warehouses';
    protected $primaryKey = 'warehouse_id';
    protected $keyType = 'string';

    protected $fillable = [
        'warehouse_id', 'slug', 'warehouse_address',
        'warehouse_city', 'warehouse_status'
    ];

    public static function generateWarehouseId()
    {
        $warehouse_id = DB::table('warehouses')->max('warehouse_id');
        $add_zero = "";
        $warehouse_id = str_replace("W", "", $warehouse_id);
        $warehouse_id = (int) $warehouse_id + 1;
        $increment_warehouse_id = $warehouse_id;

        if (strlen($warehouse_id) == 1) {
            $add_zero = "000";
        } elseif (strlen($warehouse_id) == 2) {
            $add_zero = "00";
        } elseif (strlen($warehouse_id) == 3) {
            $add_zero = "0";
        }

        $new_warehouse_id = "W" . $add_zero . $increment_warehouse_id;
        return $new_warehouse_id;
    }
}
