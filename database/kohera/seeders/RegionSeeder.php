<?php

namespace Database\Kohera\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Kohera\Region;
use Database\Kohera\Factories\RegionFactory;

class RegionSeeder extends Seeder
{
    protected $connection = 'kohera-testing';

    public function run()
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