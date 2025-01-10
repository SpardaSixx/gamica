<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            'title' => 'Tekken',
            'release_year' => 1995,
            'user_id' => 1,
            'platform_id' => 1,
            'serial_number' => 'SLES-1234',
            'region_id' => 1,
            'release_id' => 1,
            'language_id' => 2,
            'collection_id' => 1,
            'manual' => 1,
            'special_edition' => 0,
            'has_photo' => 0,
            'sealed' => 0,
            'deleted' => 0,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);

        DB::table('games')->insert([
            'title' => 'Halo',
            'release_year' => 2001,
            'user_id' => 1,
            'platform_id' => 2,
            'serial_number' => 'XBGA-0001',
            'region_id' => 1,
            'release_id' => 1,
            'language_id' => 2,
            'collection_id' => null,
            'manual' => 1,
            'special_edition' => 0,
            'has_photo' => 0,
            'sealed' => 0,
            'deleted' => 0,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
    }
}
