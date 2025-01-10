<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('platforms')->insert([
            'title' => 'PlayStation',
            'title_short' => 'PS',
            'company_id' => 1,
            'release_year' => 1995,
            'description' => 'Lorem ipsum...',
            'deleted' => 0,
            'has_photo' => 0,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);

        DB::table('platforms')->insert([
            'title' => 'XBOX',
            'title_short' => 'XBOX',
            'company_id' => 1,
            'release_year' => 2001,
            'description' => 'Lorem ipsum...',
            'deleted' => 0,
            'has_photo' => 0,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
    }
}
