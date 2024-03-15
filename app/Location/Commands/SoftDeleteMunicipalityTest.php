<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Municipality;
use Database\Main\Factories\MunicipalityFactory;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SoftDeleteMunicipalityTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteMunicipality(): void
    {
        $Municipality = MunicipalityFactory::new()->create();

        $this->dispatchSync(new SoftDeleteMunicipality($Municipality));
        
        $this->assertSoftDeleted($Municipality);
    }
}