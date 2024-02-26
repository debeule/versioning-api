<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Sport\Queries\AllSports;
use App\Sport\Sport;
use Database\Main\Factories\SportFactory;


final class AllSportsTest extends TestCase
{
    #[Test]
    public function ItCanGetAllSports(): void
    {
        SportFactory::new()->count(3)->create();

        $allSports = new AllSports;
        $result = $SportByName->get();

        $allSportRecords = Sport::get();

        $this->assertEquals($allSportRecords->count(), $result->count());
    }
}