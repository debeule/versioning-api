<?php

declare(strict_types=1);

namespace Database\Kohera\Seeders;

use Database\Kohera\Factories\SportFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportSeeder extends Seeder
{
    protected $connection = 'kohera-testing';

    public function run(): void
    {
        SportFactory::new()
            ->count(50)
            ->create();

        DB::connection('kohera-testing')->table('sports')->insert([
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
        ]);
    }
}