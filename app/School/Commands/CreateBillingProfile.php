<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Imports\Queries\BillingProfile;
use App\School\BillingProfile as DbBillingProfile;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateBillingProfile
{
    use DispatchesJobs;

    public function __construct(
        public BillingProfile $billingProfile
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->billingProfile)->save();
    }    

    private function buildRecord(BillingProfile $billingProfile): DbBillingProfile
    {
        $newBillingProfile = new DbBillingProfile();

        $newBillingProfile->record_id = $billingProfile->recordId();
        $newBillingProfile->name = $billingProfile->name();
        $newBillingProfile->email = $billingProfile->email();
        $newBillingProfile->vat_number = $billingProfile->vatNumber();
        $newBillingProfile->tav = $billingProfile->tav();
        $newBillingProfile->address_id = $billingProfile->address()->id;
        $newBillingProfile->school_id = $billingProfile->school()->id;
        
        return $newBillingProfile;
    }
}