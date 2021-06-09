<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['user_name' => 'admin', 'name' => 'Trương Văn Dương', 'email' => 'duong9294@gmail.com', 'avatar' => 'admin.png', 'role_id' => 1, 'password' => bcrypt('123456'), 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
            ['user_name' => 'user', 'name' => 'Văn Trương Dương', 'email' => 'duong123@gmail.com', 'avatar' => 'user.png', 'role_id' => 2, 'password' => bcrypt('123456'), 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
            ['user_name' => 'duong123', 'name' => 'Dương Trương Văn', 'email' => 'duong456@gmail.com', 'avatar' => 'user.png', 'role_id' => 2, 'password' => bcrypt('123456'), 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ]);
    }
}
