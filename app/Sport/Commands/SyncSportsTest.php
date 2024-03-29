<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;
use App\Testing\TestCase;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncSportsTest extends TestCase
{
    #[Test]
    public function itCreatesSportREcordsWhenNotExists(): void
    {
        KoheraSportFactory::new()->create();

        $syncSports = new SyncSports();
        $syncSports();

        $this->assertEquals(Sport::count(), KoheraSport::count());
    }

    #[Test]
    public function itSoftDeletesRecordsWhenDeleted(): void
    {
        $koheraSports = KoheraSportFactory::new()->count(2)->create();

        $syncSports = new SyncSports();
        $syncSports();
        
        $koheraSportRecordId = $koheraSports->first()->recordId();
        $koheraSports->first()->delete();

        $syncSports = new SyncSports();
        $syncSports();
        
        $this->assertSoftDeleted(Sport::where('record_id', $koheraSportRecordId)->first());
        $this->assertGreaterThan(KoheraSport::count(), Sport::count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraSport = KoheraSportFactory::new()->create();
        
        $syncSports = new SyncSports();
        $syncSports();

        $oldSport = Sport::where('name', $koheraSport->name())->first();

        $koheraSport->Sportkeuze = 'new name';
        $koheraSport->save();
        
        $syncSports = new SyncSports();
        $syncSports();

        $updatedSport = Sport::where('name', $koheraSport->name())->first();

        $this->assertTrue($oldSport->name !== $updatedSport->name);
        $this->assertSoftDeleted($oldSport);

        $this->assertEquals($updatedSport->name, $koheraSport->name());
        $this->assertEquals($oldSport->record_id, $updatedSport->record_id);
    }
}