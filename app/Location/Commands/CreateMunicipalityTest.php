<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use App\Testing\RefreshDatabase;
use App\Location\Commands\CreateMunicipality;
use App\Bpost\Municipality as BpostMunicipality;
use App\Location\Municipality;


final class CreateMunicipalityTest extends TestCase
{
    private BpostMunicipality $bpostMunicipality;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->bpostMunicipality = BpostMunicipalityFactory::new()->make();
    } 

    /**
     * @test
     */
    public function itCanCreateMunicipalityFromBpostMunicipality(): void
    {
        $this->dispatchSync(new CreateMunicipality($this->bpostMunicipality));
        
        $Municipality = Municipality::where('postal_code', $this->bpostMunicipality->postalCode())->first();
        
        $this->assertInstanceOf(BpostMunicipality::class, $this->bpostMunicipality);
        $this->assertInstanceOf(Municipality::class, $Municipality);
        
        $this->assertEquals($this->bpostMunicipality->postalCode(), $Municipality->postal_code);
    }

    /**
     * @test
     */
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $this->dispatchSync(new CreateMunicipality($this->bpostMunicipality));

        $this->assertFalse($this->dispatchSync(new CreateMunicipality($this->bpostMunicipality)));
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->dispatchSync(new CreateMunicipality($this->bpostMunicipality));

        $oldMunicipalityRecord = Municipality::where('name', $this->bpostMunicipality->name())->first();

        $bpostMunicipalityClone = clone($this->bpostMunicipality);
        $bpostMunicipalityClone->Plaatsnaam = 'new name';

        $this->dispatchSync(new CreateMunicipality($bpostMunicipalityClone));

        $updatedMunicipalityRecord = Municipality::where('name', $bpostMunicipalityClone->name())->first();

        $this->assertNotEquals($oldMunicipalityRecord->name, $updatedMunicipalityRecord->name);
        $this->assertSoftDeleted($oldMunicipalityRecord);

        $this->assertEquals($updatedMunicipalityRecord->name, $this->bpostMunicipality->name());
        $this->assertEquals($oldMunicipalityRecord->Municipality_id, $updatedMunicipalityRecord->Municipality_id);
    }
}