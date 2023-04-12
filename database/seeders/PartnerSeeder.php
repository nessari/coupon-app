<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([
            'name' => 'LIDL Újszász utca',
            'address' => 'Újszász utca 47b',
            'city' => 'Budapest',
            'hours' => '9:00am-6:00pm',
            'latitude' => 47.505652,
            'longitude' => 19.200843,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('partners')->insert([
            'name' => 'Mátyásföldi Jégcsarnok',
            'address' => 'Újszász utca 47/G',
            'city' => 'Budapest',
            'hours' => '10:00am-8:00pm',
            'latitude' => 47.503823,
            'longitude' => 19.201601,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('partners')->insert([
            'name' => 'Erzsébet ligeti futópálya',
            'address' => 'Erzsébet-liget',
            'city' => 'Budapest',
            'hours' => '12:00pm-10:00pm',
            'latitude' => 47.509587,
            'longitude' => 19.206125,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
