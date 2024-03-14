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
        if (! $this->recordExists($this->koheraBillingProfile)) 
        {
            return $this->buildRecord($this->koheraBillingProfile);
        }
        
        if ($this->recordHasChanged($this->koheraBillingProfile)) 
        {
            return $this->createNewRecordVersion($this->koheraBillingProfile);
        }

        return false;
    }

    private function recordExists(KoheraBillingProfile $koheraBillingProfile): bool
    {
        return BillingProfile::where('record_id', $koheraBillingProfile->recordId())->exists();
    }

    private function recordHasChanged(KoheraBillingProfile $koheraBillingProfile): bool
    {
        $billingProfile = BillingProfile::where('record_id', $koheraBillingProfile->recordId())->first();

        $recordHasChanged = false;

        $recordHasChanged = $billingProfile->record_id !== $koheraBillingProfile->recordId();
        $recordHasChanged = $recordHasChanged || $billingProfile->name !== $koheraBillingProfile->name();
        $recordHasChanged = $recordHasChanged || $billingProfile->email !== $koheraBillingProfile->email();
        $recordHasChanged = $recordHasChanged || $billingProfile->vat_number !== $koheraBillingProfile->vatNumber();
        $recordHasChanged = $recordHasChanged || $billingProfile->tav !== $koheraBillingProfile->tav();
        $recordHasChanged = $recordHasChanged || $billingProfile->address_id !== $koheraBillingProfile->address()->id;
        $recordHasChanged = $recordHasChanged || $billingProfile->school_id !== $koheraBillingProfile->school()->id;
        
        return $recordHasChanged;
    }

    private function buildRecord(KoheraBillingProfile $koheraBillingProfile): bool
    {
        $newbillingProfile = new BillingProfile();


        $newbillingProfile->record_id = $koheraBillingProfile->recordId();
        $newbillingProfile->name = $koheraBillingProfile->name();
        $newbillingProfile->email = $koheraBillingProfile->email();
        $newbillingProfile->vat_number = $koheraBillingProfile->vatNumber();
        $newbillingProfile->tav = $koheraBillingProfile->tav();
        $newbillingProfile->address_id = $koheraBillingProfile->address()->id;
        $newbillingProfile->school_id = $koheraBillingProfile->school()->id;

        return $newbillingProfile->save();
    }

    private function createNewRecordVersion(KoheraBillingProfile $koheraBillingProfile): bool
    {
        BillingProfile::where('record_id', $koheraBillingProfile->recordId())->delete();

        return $this->buildRecord($koheraBillingProfile);
    }
}