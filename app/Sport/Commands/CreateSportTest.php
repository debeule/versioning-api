<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Testing\TestCase;
use App\Sport\Sport;
use App\Kohera\Sport as KoheraSport;
use App\Testing\RefreshDatabase;
use App\Sport\Commands\CreateSport;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateSportTest extends TestCase
{
    use RefreshDatabase, DispatchesJobs;

    private KoheraSport $koheraSport;

    public function __construct()
    {
        $this->koheraSport = KoheraSport::factory()->create();
    }
    
    /** @test */
    public function itCanCreateASportFromkoheraSport()
    {
        $this->dispatchSync(new CreateSport($this->koheraSport));
        
        $sport = Sport::where('name', $koheraSport->name())->first();
        
        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);

        $this->assertTrue($this->koheraSport->name() === $sport->name);
    }

    public function itCanUpdateASportFromKoheraSport()
    {
        $this->dispatchSync(new CreateSport($this->koheraSport));

        $oldSportRecord = Sport::where('name', $this->koheraSport->name())->first();

        $this->koheraSport->Sportkeuze = 'new name';
        $this->dispatchSync(new CreateSport($this->koheraSport));

        $updatedSportRecord = Sport::where('name', $this->koheraSport->name())->first();

        $this->assertInstanceOf(Sport::class, $oldSportRecord);
        $this->assertInstanceOf(Sport::class, $updatedSportRecord);

        $this->assertTrue($oldSportRecord->name !== $updatedSportRecord->name);
        $this->assertNotNull($oldSportRecord->deleted_at);

        $this->assertTrue($updatedSportRecord->name === $this->koheraSport->name());

        $this->assertTrue($oldSportRecord->sport_id === $updatedSportRecord->sport_id);
    }
}