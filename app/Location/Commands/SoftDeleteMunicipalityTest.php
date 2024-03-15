<?php

declare(strict_types=1);

namespace App\Municipality\Commands;

use App\Kohera\Municipality as KoheraMunicipality;
use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Kohera\Factories\MunicipalityFactory as KoheraMunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteMunicipalityTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteMunicipality()
    {
        $Municipality = Municipality::factory()->create();

        $this->dispatchSync(new SoftDeleteMunicipality($Municipality));
        
        $this->assertSoftDeleted($Municipality);
    }
}