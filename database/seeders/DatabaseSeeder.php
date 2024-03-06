<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Kohera\Seeders\RegionSeeder as KoheraRegionSeeder;

use Database\Kohera\Seeders\SchoolSeeder as KoheraSchoolSeeder;
use Database\Kohera\Seeders\SportSeeder as KoheraSportSeeder;
use Illuminate\Database\Seeder;

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
