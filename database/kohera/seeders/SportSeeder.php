<?php

namespace Database\Kohera\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Kohera\Sport;

use App\Database\Kohera\Factories\SportFactory;


class SportSeeder extends Seeder
{
    protected $connection = 'sqlite';

    public function run()
    {
        Sport::factory()
            ->count(50)
            ->create();

        DB::connection('sqlite')->table('sports')->insert([
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
            ]
        ]);
    }
}