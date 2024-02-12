<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Kohera\Seeders\SportSeeder as KoheraSportSeeder;
use Database\Kohera\Seeders\RegionSeeder as KoheraRegionSeeder;
use Database\Kohera\Seeders\SchoolSeeder as KoheraSchoolSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KoheraSportSeeder::class,
            KoheraRegionSeeder::class,
            KoheraSchoolSeeder::class,
        ]);
    }
}
