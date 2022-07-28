<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'slug', 'username', 'email', 'password', 'type', 'status'
    ];

    protected $hidden = [
        'password'
    ];

    public static function generateUserId()
    {
        $user_id = DB::table('users')->max('user_id');
        $add_zero = "";
        $user_id = str_replace("U", "", $user_id);
        $user_id = (int) $user_id + 1;
        $increment_user_id = $user_id;

        if (strlen($user_id) == 1) {
            $add_zero = "000";
        } elseif (strlen($user_id) == 2) {
            $add_zero = "00";
        } elseif (strlen($user_id) == 3) {
            $add_zero = "0";
        }

        $new_user_id = "U" . $add_zero . $increment_user_id;
        return $new_user_id;
    }
}
