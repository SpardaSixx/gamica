<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

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
            'username' => 'Sparda',
            'email' => 'spardasixx@gmail.com',
            'password' => Hash::make('12345678'),
            'default_language' => 'hu',
            'fb_profile' => 'https://www.facebook.com/roland.gorbicz',
            'ig_profile' => 'https://www.instagram.com/spardasixx/',
            'xp_points' => '0',
            'rank_id' => 3,
            'country_id' => 1,
            'city_id' => 1,
            'has_photo' => 0,
            'deleted' => 0,
            'email_verified_at' =>Carbon::now(),
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);

        DB::table('users')->insert([
            'username' => 'Dante',
            'email' => 'dante@dmc.jp',
            'password' => Hash::make('12345678'),
            'default_language' => 'hu',
            'fb_profile' => '',
            'ig_profile' => '',
            'xp_points' => '0',
            'rank_id' => 1,
            'country_id' => 1,
            'city_id' => 2,
            'has_photo' => 0,
            'deleted' => 0,
            'email_verified_at' =>Carbon::now(),
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
    }
}
