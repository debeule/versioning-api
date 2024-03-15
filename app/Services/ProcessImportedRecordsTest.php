<?php

declare(strict_types=1);

namespace App\Services;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class ProcessImportedRecordsTest
{
    #[Test]
    public function FiltersOutExistingRecords(): void
    {
        $allSports = Sport::factory()->count(3)->create();

        $koheraSports = KoheraSportFactory::new()->create();

        $result = ProcessImportedRecords::setup($KoheraSports, $Sports)->pipe();

        $createSport = new CreateSport($koheraSports);
        
        $processedResult = ProcessImportedRecords::setup($KoheraSports, $Sports)->pipe();

        $this->assertEquals("a", "b");
    }
}