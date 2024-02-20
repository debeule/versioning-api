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
    private KoheraSport $koheraSport;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSport = KoheraSportFactory::new()->create();
    } 

    /**
     * @test
     */
    public function itCanCreateSportFromKoheraSport(): void
    {
        $this->dispatchSync(new CreateSport($this->koheraSport));
        
        $sport = Sport::where('sport_id', $this->koheraSport->sportId())->first();
        
        $this->assertInstanceOf(koheraSport::class, $this->koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);

        $this->assertTrue($this->koheraSport->name() === $sport->name);
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->dispatchSync(new CreateSport($this->koheraSport));

        $oldSportRecord = Sport::where('name', $this->koheraSport->name())->first();

        $this->koheraSport->Sportkeuze = 'new name';
        $this->dispatchSync(new CreateSport($this->koheraSport));

        $updatedSportRecord = Sport::where('name', $this->koheraSport->name())->first();

        $this->assertTrue($oldSportRecord->name !== $updatedSportRecord->name);
        $this->assertSoftDeleted($oldSportRecord);

        $this->assertEquals($updatedSportRecord->name, $this->koheraSport->name());
        $this->assertEquals($oldSportRecord->sport_id, $updatedSportRecord->sport_id);
    }
}