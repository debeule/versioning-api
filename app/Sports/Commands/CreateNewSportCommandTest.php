<?php

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Testing\TestCase;
use App\Sports\Commands\CreateNewSportCommand;
use App\Sports\Sport;
use App\Kohera\Sport as KoheraSport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;


final class CreateNewSportCommandTest extends TestCase
{
    /** @test */
    public function itCanCreateASportFromkoheraSport()
    {
        $koheraSport = KoheraSport::factory()->create();

        $createNewSportCommand = new CreateNewSportCommand;

        $sportCreated = $createNewSportCommand($koheraSport);

        $sport = Sport::where('name', $koheraSport->Sportkeuze)->first();

        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertTrue($sportCreated);
    }
}