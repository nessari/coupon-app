<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            // order is important!
            CategorySeeder::class,
            PartnerSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            CouponSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@testmail.com',
            'password' => 'password'
        ]);

    }
}
