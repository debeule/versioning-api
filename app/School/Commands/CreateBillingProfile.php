<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\BillingProfile;
use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\School\Municipality;
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
        
        if ($this->recordExists($this->koheraBillingProfile) && $this->recordHasChanged($this->koheraBillingProfile)) 
        {
            return $this->createNewRecordVersion($this->koheraBillingProfile);
        }

        return true;
    }

    private function recordExists(KoheraBillingProfile $koheraBillingProfile): bool
    {
        return BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->exists();
    }

    private function recordHasChanged(KoheraBillingProfile $koheraBillingProfile): bool
    {
        $billingProfile = BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->first();

        $recordhasChanged = $recordhasChanged || $billingProfile->billing_profile_id !== $koheraBillingProfile->billingProfileId();
        $recordhasChanged = $recordhasChanged || $billingProfile->name !== $koheraBillingProfile->name();
        $recordhasChanged = $recordhasChanged || $billingProfile->email !== $koheraBillingProfile->email();
        $recordhasChanged = $recordhasChanged || $billingProfile->vat_number !== $koheraBillingProfile->vatNumber();
        $recordhasChanged = $recordhasChanged || $billingProfile->tav !== $koheraBillingProfile->tav();
        $recordhasChanged = $recordhasChanged || $billingProfile->address_id !== $koheraBillingProfile->address()->id;
        $recordhasChanged = $recordhasChanged || $billingProfile->school_id !== $koheraBillingProfile->school()->id;

        return $recordhasChanged;
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
        $billingProfile = BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->delete();

        return $this->buildRecord($koheraBillingProfile);
    }
}