<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\School\BillingProfile;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SoftDeleteBillingProfile
{
    use DispatchesJobs;

    public function __construct(
        public BillingProfile $billingProfile
    ) {}

    public function handle(): bool
    {
        return $this->billingProfile->delete();
    }
}