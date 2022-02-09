<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'order_no' => 000001,
            'has_coupon_code' => null,
            'status' => 1
        ]);
    }
}
