<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\School\BillingProfile;
use App\School\Commands\CreateBillingProfile;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\MunicipalityFactory;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;


final class BillingProfileDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectAdditions2(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
            MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
            AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();
        }
        
        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($koheraSchools->first())));

        $billingProfile = BillingProfile::first();
        $billingProfile->record_id = $koheraSchools->first()->recordId();
        $billingProfile->save();

        $billingProfileDiff = app(BillingProfileDiff::class);

        $result = $billingProfileDiff->additions();

        $this->assertInstanceOf(KoheraBillingProfile::class, $result->first());
        $this->assertEquals(2, $result->count());
    }
    
    #[Test]
    public function itReturnsCorrectDeletions(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
            MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
            AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();
        }

        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($koheraSchools->first())));

        $removedKoheraSchool = $koheraSchools->first();
        $billingProfile = BillingProfile::first();
        $billingProfile->record_id = $removedKoheraSchool->recordId();
        $billingProfile->save();

        $removedKoheraSchool->delete();

        $billingProfileDiff = app(BillingProfileDiff::class);

        $result = $billingProfileDiff->deletions();

        $this->assertInstanceOf(BillingProfile::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('record_id', $removedKoheraSchool->recordId())->isNotEmpty());
    }
    
    #[Test]
    public function itReturnsCorrectUpdates2(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
            MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
            AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();
        }

        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($koheraSchools->first())));
        $billingProfile = BillingProfile::first();
        $billingProfile->record_id = $koheraSchools->first()->recordId();
        $billingProfile->save();

        $updatedKoheraSchool = $koheraSchools->first();
        $updatedKoheraSchool->Address = "streetname 1";
        $updatedKoheraSchool->save();

        $billingProfileDiff = app(BillingProfileDiff::class);

        $result = $billingProfileDiff->updates();

        $this->assertInstanceOf(KoheraBillingProfile::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('record_id', $updatedKoheraSchool->recordId())->isNotEmpty());
    }
}