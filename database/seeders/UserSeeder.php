<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Users;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = (object)[
            [
                "username" => "superadmin",
                "email" => "superadmin@admin.com",
                "type" => "admin",
                "password" => bcrypt("admin123"),
                "status" => "Active"
            ]
        ];

        foreach ($datas as $data) {
            $data = (object)$data;
            $user_id = Users::generateUserId();
            Users::create([
                'user_id' => $user_id,
                'slug' => Str::random(16),
                'username' => $data->username,
                'email' => $data->email,
                'password' => $data->password,
                'type' => $data->type,
                'status' => $data->status
            ]);
        }
    }
}
