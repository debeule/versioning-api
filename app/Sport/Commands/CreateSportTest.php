<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Testing\TestCase;
use App\Sport\Commands\CreateSport;
use App\Sport\Sport;
use App\Kohera\Sport as KoheraSport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;


final class CreateSportTest extends TestCase
{
    protected $connectionsToTransact = ['main-testing'];

    use RefreshDatabase;
    
    /** @test */
    public function itCanCreateASportFromkoheraSport()
    {
        $koheraSport = KoheraSport::factory()->create();

        $createSport = new CreateSport;

        $sportCreated = $createSport($koheraSport);

        $sport = Sport::where('name', $koheraSport->Sportkeuze)->first();

        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertTrue($sportCreated);
    }
}