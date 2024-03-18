<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Testing\TestCase;
use Database\Main\Factories\MunicipalityFactory;
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