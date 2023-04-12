<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->times(10)->hasReviews(2)->hasBillingDetails()->create();

        $coupons = Coupon::all();
        User::all()->each(function ($user) use($coupons) {
            $user->coupons()->attach(
                $coupons->random(10)->pluck('id')
            );
        });
    }
}
