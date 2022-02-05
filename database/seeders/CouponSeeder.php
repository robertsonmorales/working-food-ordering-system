<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    protected $coupon;
    public function __construct(Coupon $coupon){
        $this->coupon = $coupon;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->coupon->create([
            'code' => 'GO2018',
            'name' => 'Go 2018 Coupon',
            'percentage' => '10'
        ]);
    }
}
