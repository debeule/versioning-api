<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegioSeeder extends Seeder
{
    public function run()
    {
        DB::connection('sqlite')->table('SNS-Regio')->insert([
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