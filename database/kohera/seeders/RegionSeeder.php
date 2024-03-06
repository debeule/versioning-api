<?php

declare(strict_types=1);

namespace Database\Kohera\Seeders;

use Database\Kohera\Factories\RegionFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    protected $connection = 'kohera-testing';

    public function run(): void
    {
        RegionFactory::new()
            ->count(50)
            ->create();

        DB::connection('kohera-testing')->table('regions')->insert([
            [
                'RegionNaam' => "Haspengouw",
                'Provincie' => "Limburg",
                'Postcode' => "3570",
                'RegioDetailId' => "16",
            ],
            [
                'RegionNaam' => "Oost-Limburg",
                'Provincie' => "Limburg",
                'Postcode' => "3630",
                'RegioDetailId' => "17",
            ],
            [
                'RegionNaam' => "Oost-Limburg",
                'Provincie' => "Limburg",
                'Postcode' => "3631",
                'RegioDetailId' => "17",
            ],
            [
                'RegionNaam' => "Oost-Limburg",
                'Provincie' => "Limburg",
                'Postcode' => "3640",
                'RegioDetailId' => "17",
            ],
            [
                'RegionNaam' => "Oost-Limburg",
                'Provincie' => "Limburg",
                'Postcode' => "3650",
                'RegioDetailId' => "17",
            ],
            [
                'RegionNaam' => "Oost-Limburg",
                'Provincie' => "Limburg",
                'Postcode' => "3665",
                'RegioDetailId' => "17",
            ],
        ]);
    }
}