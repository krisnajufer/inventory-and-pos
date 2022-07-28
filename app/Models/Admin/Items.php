<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Items extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'item_id';
    protected $keyType = 'string';

    protected $fillable = [
        'item_id', 'slug', 'item_name', 'price_item'
    ];

    public static function generateItemId()
    {
        $item_id = DB::table('items')->max('item_id');
        $add_zero = "";
        $item_id = str_replace("I", "", $item_id);
        $item_id = (int) $item_id + 1;
        $increment_item_id = $item_id;

        if (strlen($item_id) == 1) {
            $add_zero = "000";
        } elseif (strlen($item_id) == 2) {
            $add_zero = "00";
        } elseif (strlen($item_id) == 3) {
            $add_zero = "0";
        }

        $new_item_id = "I" . $add_zero . $increment_item_id;
        return $new_item_id;
    }
}
