<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Sport\Sport;
use App\Testing\TestCase;
use Database\Main\Factories\SportFactory;
use PHPUnit\Framework\Attributes\Test;


final class AllSportsTest extends TestCase
{
    #[Test]
    public function ItCanGetAllSports(): void
    {
        SportFactory::new()->count(3)->create();

        $allSports = new AllSports;
        $result = $allSports->get();

        $allSportRecords = Sport::get();

        $this->assertEquals($allSportRecords->count(), $result->count());
    }
}