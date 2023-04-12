<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Category;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Review;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::factory()->times(2)->hasReviews(11)->create();
        // Category::factory()->times(4)->create();
        // Order::factory()->times(10)->create();

        $categories = Category::all();
        Coupon::all()->each(function ($coupon) use($categories) {
            $coupon->category()->associate(
                $categories->random(1)->pluck('id')
            );
        });

        $orders = Order::all();
        Coupon::all()->each(function ($coupon) use($orders) {
            $orderIds = $orders->random(2)->pluck('id')->toArray();
            foreach($orderIds as $orderId) {
                $coupon->orders()->attach($orderId, ['quantity' => rand(1, 5)]);
            }
        });

        $partners = Partner::all();
        Coupon::all()->each(function ($coupon) use($partners) {
            $coupon->partner()->associate(
                $partners->random(1)->pluck('id')
            );
        });
    }
}
