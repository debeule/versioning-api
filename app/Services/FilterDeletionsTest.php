<?php

declare(strict_types=1);

namespace App\Services;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class FilterDeletionsTest extends TestCase
{
    #[Test]
    public function deleteContainsDeletedRecords(): void
    {
        SchoolFactory::new()->create();

        $result = $this->DispatchSync(new FilterDeletions(
            School::get(),
            KoheraSchool::get()
        ));
            
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(School::class, $result->first());
        $this->assertEquals(1, $result->count());
    }

    #[Test]
    public function deleteDoesNotContainDeletedRecords(): void
    {
        $schools = SchoolFactory::new()->count(3)->create();
        $schools->first()->delete();

        $result = $this->DispatchSync(new FilterDeletions(
            School::whereNull('deleted_at')->get(),
            KoheraSchool::get()
        ));
        
        $this->assertEquals(2, $result->count());
    }
}