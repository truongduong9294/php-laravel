<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ['category_id' => 1, 'product_name' => 'Iphone 6', 'image' => 'iphone6.jpg', 'price' => 100, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
            ['category_id' => 1, 'product_name' => 'Iphone 7', 'image' => 'iphone7.jpg', 'price' => 120, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
            ['category_id' => 1, 'product_name' => 'Iphone 8', 'image' => 'iphone8.jpg', 'price' => 130, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
            ['category_id' => 2, 'product_name' => 'Asus', 'image' => 'asus.jpg', 'price' => 100, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
            ['category_id' => 2, 'product_name' => 'Del', 'image' => 'del.jpg', 'price' => 120, 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ]);
    }
}
