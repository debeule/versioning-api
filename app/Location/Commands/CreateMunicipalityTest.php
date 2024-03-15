<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Bpost\Municipality as BpostMunicipality;
use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;


final class CreateMunicipalityTest extends TestCase
{
    #[Test]
    public function itCanCreateMunicipalityFromBpostMunicipality(): void
    {
        $bpostMunicipality = BpostMunicipalityFactory::new()->create();

        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));
        
        $Municipality = Municipality::where('postal_code', $bpostMunicipality->postalCode())->first();
        
        $this->assertInstanceOf(BpostMunicipality::class, $bpostMunicipality);
        $this->assertInstanceOf(Municipality::class, $Municipality);
        
        $this->assertEquals($bpostMunicipality->postalCode(), $Municipality->postal_code);
    }
}