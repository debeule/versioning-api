<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllBillingProfiles as AllKoheraBillingProfiles;
use App\School\BillingProfile;
use App\School\Commands\CreateBillingProfile;
use App\School\Commands\SoftDeleteBillingProfile;

use App\Services\ProcessImportedRecords;

use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncBillingProfiles
{
    use DispatchesJobs;

    public function __construct(
        private AllKoheraBillingProfiles $allKoheraBillingProfiles = new AllKoheraBillingProfiles(),
    ) {}
        

    public function __invoke(): void
    {
        $allBillingProfiles = BillingProfile::get();

        $result = ProcessImportedRecords::setup($this->allKoheraBillingProfiles->get(), $allBillingProfiles)->pipe();
        
        foreach ($result['update'] as $koheraBillingProfile)
        {
            $this->dispatchSync(new SoftDeleteBillingProfile(BillingProfile::where('record_id', $koheraBillingProfile->recordId())->first()));
            $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));
        }

        foreach ($result['create'] as $koheraBillingProfile) 
        {
            $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));
        }

        foreach ($result['delete'] as $billingProfile) 
        {
            $this->dispatchSync(new SoftDeleteBillingProfile($billingProfile));
        }
    }
}