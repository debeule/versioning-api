<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Testing\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Kohera\Address;
use Database\Kohera\Factories\SchoolFactory  as KoheraSchoolFactory;

final class AllMunicipalitiesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function placeholder(): void
    {
        $this->assertTrue(true);
    }
}