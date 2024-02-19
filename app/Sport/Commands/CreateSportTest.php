<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Testing\TestCase;
use App\Sport\Sport;
use App\Kohera\Sport as KoheraSport;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use App\Testing\RefreshDatabase;
use App\Sport\Commands\CreateSport;


final class CreateSportTest extends TestCase
{    
    /**
     * @test
     */
    public function itCanCreateASportFromkoheraSport(): void
    {
        $koheraSport = KoheraSportFactory::new()->create();

        $this->dispatchSync(new CreateSport($koheraSport));
        
        $sport = Sport::where('sport_id', $koheraSport->sportId())->first();
        
        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);

        $this->assertTrue($koheraSport->name() === $sport->name);
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraSport = KoheraSportFactory::new()->create();

        $this->dispatchSync(new CreateSport($koheraSport));

        $oldSportRecord = Sport::where('name', $koheraSport->name())->first();

        $koheraSport->Sportkeuze = 'new name';
        $this->dispatchSync(new CreateSport($koheraSport));

        $updatedSportRecord = Sport::where('name', $koheraSport->name())->first();

        $this->assertTrue($oldSportRecord->name !== $updatedSportRecord->name);
        $this->assertSoftDeleted($oldSportRecord);

        $this->assertEquals($updatedSportRecord->name, $koheraSport->name());
        $this->assertEquals($oldSportRecord->sport_id, $updatedSportRecord->sport_id);
    }
}