<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Kohera\BillingProfile;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;

final class AllBillingProfilesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        KoheraSchoolFactory::new()->count(3)->create();

        $this->allBillingProfiles = new AllBillingProfiles;
    }

    /**
     * @test
     */
    public function queryReturnsBuilderInstance(): void
    {
        $this->assertInstanceOf(Builder::class, $this->allBillingProfiles->query());
    }

    /**
     * @test
     */
    public function getReturnsCollectionOfBillingProfiles(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allBillingProfiles->get());
        $this->assertInstanceOf(BillingProfile::class, $this->allBillingProfiles->get()[0]);
    }
}