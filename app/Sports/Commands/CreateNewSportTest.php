<?php

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Testing\TestCase;
use App\Sports\Commands\CreateNewSport;
use App\Sports\Sport;
use App\Kohera\Sport as KoheraSport;
use App\Testing\RecursiveRefreshDatabase as RefreshDatabase;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;


final class CreateNewSportTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function itCanCreateASportFromkoheraSport()
    {
        $koheraSport = KoheraSport::factory()->create();

        $createNewSport = new CreateNewSport;

        $sportCreated = $createNewSport($koheraSport);

        $sport = Sport::where('name', $koheraSport->Sportkeuze)->first();

        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertTrue($sportCreated);
    }
}