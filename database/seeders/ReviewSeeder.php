<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::factory()->times(2)->create();

        $coupons = Coupon::all();
        Review::all()->each(function ($review) use($coupons) {
            $review->coupon()->associate(
                $coupons->random(1)->pluck('id')
            );
        });

        $users = User::all();
        Review::all()->each(function ($review) use($users) {
            $review->user()->associate(
                $users->random(1)->pluck('id')
            );
        });
    }
}
