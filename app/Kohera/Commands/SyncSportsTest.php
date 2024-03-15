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
    public function itCreatesSportWhenNotExists(): void
    {
        KoheraSportFactory::new()->count(3)->create();
        $syncSports = new SyncSports();
        $syncSports();

        KoheraSportFactory::new()->count(3)->create();

        $existingSports = Sport::get();
        $koheraSports = KoheraSport::get();

        $this->assertGreaterThan($existingSports->count(), $koheraSports->count());

        $syncSports = new SyncSports();
        $syncSports();

        $existingSports = Sport::get();
        $koheraSports = KoheraSport::get();
        $this->assertEquals($existingSports->count(), $koheraSports->count());
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        KoheraSportFactory::new()->count(3)->create();
        $syncSports = new SyncSports();
        $syncSports();

        $koheraSport = KoheraSport::first();
        $koheraSportName = $koheraSport->name();
        $koheraSport->delete();

        $syncSports = new SyncSports();
        $syncSports();
            
        $this->assertSoftDeleted(Sport::where('name', $koheraSportName)->first());

        $existingSports = Sport::get();
        $koheraSports = KoheraSport::get();

        $this->assertGreaterThan($koheraSports->count(), $existingSports->count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $bpostMunicipality = BpostMunicipalityFactory::new()->create();

        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $oldMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();
        
        $bpostMunicipality->Plaatsnaam = 'new name';
        
        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $updatedMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();

        $this->assertNotEquals($oldMunicipalityRecord->name, $updatedMunicipalityRecord->name);
        $this->assertSoftDeleted($oldMunicipalityRecord);

        $this->assertEquals($updatedMunicipalityRecord->name, $bpostMunicipality->name());
        $this->assertEquals($oldMunicipalityRecord->record_id, $updatedMunicipalityRecord->record_id);
    }
    
}