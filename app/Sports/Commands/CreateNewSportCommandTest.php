<?php

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Testing\TestCase;
use App\Sports\Queries\CreateNewSportCommand;
use App\Sports\Sport;
use App\Kohera\DwhSport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\SportFactory;


class GetSportByNameQueryTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function itCanCreateASportFromDwhSport()
    {
        $dwhSport = DwhSportFactory::create();

        $createNewSportCommand = new CreateNewSportCommand;

        $sportCreated = $createNewSportCommand($dwhSport);

        $sport = Sport::where('name', $dwhSport->Sportkeuze)->first();

        $this->assertInstanceOf(DwhSport::class, $dwhSport);
        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertTrue($sportCreated);
    }
}