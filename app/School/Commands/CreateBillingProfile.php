<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\School\BillingProfile;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateBillingProfile
{
    use DispatchesJobs;

    public function __construct(
        public KoheraBillingProfile $koheraBillingProfile
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->koheraBillingProfile)->save();
    }    

    private function buildRecord(KoheraBillingProfile $koheraBillingProfile): BillingProfile
    {        
        $newBillingProfile = new BillingProfile();

        $newBillingProfile->record_id = $koheraBillingProfile->recordId();
        $newBillingProfile->name = $koheraBillingProfile->name();
        $newBillingProfile->email = $koheraBillingProfile->email();
        $newBillingProfile->vat_number = $koheraBillingProfile->vatNumber();
        $newBillingProfile->tav = $koheraBillingProfile->tav();
        $newBillingProfile->address_id = $koheraBillingProfile->address()->id;
        $newBillingProfile->school_id = $koheraBillingProfile->school()->id;
        
        return $newBillingProfile;
    }
}