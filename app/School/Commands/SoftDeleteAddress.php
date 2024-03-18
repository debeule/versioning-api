<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\School\Address;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SoftDeleteAddress
{
    use DispatchesJobs;

    public function __construct(
        public Address $address
    ) {}

    public function handle(): bool
    {
        return $this->address->delete();
    }
}