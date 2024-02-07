<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportSeeder extends Seeder
{
    public function run()
    {
        DB::connection('sqlite')->table('SNS-Sport')->insert([
            [
                "Sportkeuze" => "Atletiek",
                "BK_SportTakSportOrganisatie" => "00000000-0000-0000-0000-000000020000",
                "Sport" => "Atletiek",
                "HoofdSport" => "Atletiek",
            ],
            [
                "Sportkeuze" => "Start To Run",
                "BK_SportTakSportOrganisatie" => "00000000-0000-0000-0000-000000020000",
                "Sport" => "Atletiek",
                "HoofdSport" => "Atletiek",
            ],
            [
                "Sportkeuze" => "Joggen",
                "BK_SportTakSportOrganisatie" => "00000000-0000-0000-0000-000000020001",
                "Sport" => "Jogging/Joggen",
                "HoofdSport" => "Atletiek",
            ],
            [
                "Sportkeuze" => "Hoogspringen",
                "BK_SportTakSportOrganisatie" => "00000000-0000-0000-0000-000000020009",
                "Sport" => "Hoogspringen ",
                "HoofdSport" => "Atletiek",
            ],
            [
                "Sportkeuze" => "Recreatief Afstandslopen",
                "BK_SportTakSportOrganisatie" => "00000000-0000-0000-0000-000000020014",
                "Sport" => "Loopnummers",
                "HoofdSport" => "Atletiek",
            ],
            [
                "Sportkeuze" => "Marathon Man",
                "BK_SportTakSportOrganisatie" => "00000000-0000-0000-0000-000000020039",
                "Sport" => "Marathon ",
                "HoofdSport" => "Atletiek",
            ],
        ]);
    }
}