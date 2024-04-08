<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\School\Address;
use App\School\BillingProfile as DbBillingProfile;
use App\School\School;

interface BillingProfile
{
    public function recordId(): int;
    public function name(): string;
    public function email(): string;
    public function vatNumber(): string;
    public function tav(): string;

    public function address(): Address;
    public function school(): School;
    
    public function hasChanged(DbBillingProfile $dbBillingProfile): bool;


}