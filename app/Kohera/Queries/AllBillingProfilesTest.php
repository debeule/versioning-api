<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Kohera\BillingProfile;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;

final class AllBillingProfilesTest extends TestCase
{
    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();

        $this->allBillingProfiles = new AllBillingProfiles;

        $this->assertInstanceOf(Builder::class, $this->allBillingProfiles->query());
    }

    #[Test]
    public function getReturnsCollectionOfBillingProfiles(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();

        $this->allBillingProfiles = new AllBillingProfiles;
        
        $this->assertInstanceOf(Collection::class, $this->allBillingProfiles->get());
        $this->assertInstanceOf(BillingProfile::class, $this->allBillingProfiles->get()[0]);
    }
}