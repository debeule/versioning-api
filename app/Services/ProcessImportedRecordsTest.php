<?php

declare(strict_types=1);

namespace App\Services;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use Database\Main\Factories\SportFactory;
use App\Sport\Commands\CreateSport;

final class ProcessImportedRecordsTest extends TestCase
{
    #[Test]
    public function testPipelineExecution()
    {
        $koheraSports = KoheraSportFactory::new()->count(2)->create();
        
        $result = ProcessImportedRecords::setup(collect($koheraSports), Sport::get())->pipe();
        
        $this->assertNotNull($result['records']->first());
        $this->assertEquals(2, $result['records']->count());
    }
}