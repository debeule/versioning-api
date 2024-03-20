<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\School;
use App\Kohera\School as KoheraSchool;
use App\School\Commands\CreateSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Database\Main\Factories\SchoolFactory;

final class FilterDeletedRecordsTest extends TestCase
{
    #[Test]
    public function deleteContainsDeletedRecords(): void
    {
        SchoolFactory::new()->create();

        $result = app(Pipeline::class)
            ->send([
                'records' => KoheraSchool::get(),
                'existingRecords' => School::get(),
            ])
            ->through([FilterDeletedRecords::class])
            ->thenReturn();
            
        $this->assertInstanceOf(Collection::class, $result['delete']);
        $this->assertInstanceOf(School::class, $result['delete']->first());
        $this->assertEquals(1, $result['delete']->count());
    }

    #[Test]
    public function deleteDoesNotContainDeletedRecords(): void
    {
        $schools = SchoolFactory::new()->count(3)->create();
        $schools->first()->delete();

        $result = app(Pipeline::class)
            ->send([
                'records' => KoheraSchool::get(),
                'existingRecords' => School::whereNull('deleted_at')->get(),
            ])
            ->through([FilterDeletedRecords::class])
            ->thenReturn();
        
        $this->assertEquals(2, $result['delete']->count());
    }
}