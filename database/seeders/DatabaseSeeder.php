<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DwhSportSeeder;
use Database\Seeders\DwhRegionSeeder;
use Database\Seeders\DwhSchoolSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DwhSportSeeder::class,
            DwhRegionSeeder::class,
            DwhSchoolSeeder::class,
        ]);
    }
}
