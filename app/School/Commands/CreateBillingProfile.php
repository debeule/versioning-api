<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\BillingProfile;
use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateBillingProfile
{
    use DispatchesJobs;

    public function __construct(
        public KoheraBillingProfile $koheraBillingProfile
    ) {}

    public function handle(): bool
    {
        if (!$this->recordExists($this->koheraBillingProfile)) 
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
        return BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->exists();
    }

    private function recordHasChanged(KoheraBillingProfile $koheraBillingProfile): bool
    {
        $billingProfile = BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->first();

        $recordHasChanged = false;

        $recordHasChanged = $billingProfile->billing_profile_id !== $koheraBillingProfile->billingProfileId();
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


        $newbillingProfile->billing_profile_id = $koheraBillingProfile->billingProfileId();
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
        BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->delete();

        return $this->buildRecord($koheraBillingProfile);
    }
}