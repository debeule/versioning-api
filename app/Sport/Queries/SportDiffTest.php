<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Imports\Queries\ExternalSports;
use App\Kohera\Queries\AllSports;
use App\Sport\Commands\CreateSport;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;

final class SportDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectAdditions(): void
    {
        $koheraSports = KoheraSportFactory::new()->count(3)->create();

        $this->dispatchSync(new CreateSport($koheraSports->first()));

        $sportDiff = app(SportDiff::class);

        $result = $sportDiff->additions();

        $this->assertInstanceOf(KoheraSport::class, $result->first());
        $this->assertEquals(2, $result->count());
    }
    
    #[Test]
    public function itReturnsCorrectDeletions(): void
    {
        $koheraSports = KoheraSportFactory::new()->count(3)->create();
        $removedKoheraSport = $koheraSports->first();

        $removedKoheraSport->delete();

        $this->dispatchSync(new CreateSport($removedKoheraSport));

        $sportDiff = app(SportDiff::class);

        $result = $sportDiff->deletions();

        $this->assertInstanceOf(Sport::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('name', $removedKoheraSport->name())->isNotEmpty());
    }
    
    #[Test]
    public function itReturnsCorrectUpdates(): void
    {
        $koheraSports = KoheraSportFactory::new()->count(3)->create();

        $this->dispatchSync(new CreateSport($koheraSports->first()));

        $newName = "new head sport";
        $koheraSports->first()->Sportkeuze = $newName;
        $koheraSports->first()->save();

        $sportDiff = app(SportDiff::class);

        $result = $sportDiff->updates();

        $this->assertInstanceOf(KoheraSport::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertEquals($newName, $result->first()->Sportkeuze);
    }
}