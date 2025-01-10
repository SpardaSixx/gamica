<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            LanguageSeeder::class,
            RankSeeder::class,
            RegionSeeder::class,
            ReleaseSeeder::class,
            PlatformSeeder::class,
            UserSeeder::class,
            CollectionSeeder::class,
            GameSeeder::class,
        ]);
    }
}
