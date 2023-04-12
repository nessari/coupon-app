<?php

namespace Database\Seeders;

use App\Models\BillingDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class BillingDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->times(10)->create();

        $users = User::all();
        BillingDetail::all()->each(function ($billing_detail) use($users) {
            $billing_detail->user()->associate(
                $users->random(1)->pluck('id')
            );
        });
    }
}
