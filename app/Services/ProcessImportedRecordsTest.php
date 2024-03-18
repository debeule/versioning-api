<?php

declare(strict_types=1);

namespace App\Services;

use App\Sport\Sport;
use App\Testing\TestCase;

use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use PHPUnit\Framework\Attributes\Test;

final class ProcessImportedRecordsTest extends TestCase
{
    #[Test]
    public function testPipelineExecution(): void
    {
        $koheraSports = KoheraSportFactory::new()->count(2)->create();
        
        $result = ProcessImportedRecords::setup(collect($koheraSports), Sport::get())->pipe();
        
        $this->assertNotNull($result['records']->first());
        $this->assertEquals(2, $result['records']->count());
    }
}