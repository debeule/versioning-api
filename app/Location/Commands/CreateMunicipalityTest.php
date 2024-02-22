<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use App\Location\Commands\CreateMunicipality;
use App\Bpost\Municipality as BpostMunicipality;
use App\Location\Municipality;


final class CreateMunicipalityTest extends TestCase
{
    #[Test]
    public function itCanCreateMunicipalityFromBpostMunicipality(): void
    {
        $bpostMunicipality = BpostMunicipalityFactory::new()->make();

        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));
        
        $Municipality = Municipality::where('postal_code', $bpostMunicipality->postalCode())->first();
        
        $this->assertInstanceOf(BpostMunicipality::class, $bpostMunicipality);
        $this->assertInstanceOf(Municipality::class, $Municipality);
        
        $this->assertEquals($bpostMunicipality->postalCode(), $Municipality->postal_code);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $bpostMunicipality = BpostMunicipalityFactory::new()->make();

        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $this->assertFalse($this->dispatchSync(new CreateMunicipality($bpostMunicipality)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $bpostMunicipality = BpostMunicipalityFactory::new()->make();

        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $oldMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();
        
        $bpostMunicipality->Plaatsnaam = 'new name';
        
        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $updatedMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();

        $this->assertNotEquals($oldMunicipalityRecord->name, $updatedMunicipalityRecord->name);
        $this->assertSoftDeleted($oldMunicipalityRecord);

        $this->assertEquals($updatedMunicipalityRecord->name, $bpostMunicipality->name());
        $this->assertEquals($oldMunicipalityRecord->Municipality_id, $updatedMunicipalityRecord->Municipality_id);
    }
}