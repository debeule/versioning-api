<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\School\Address;
use App\School\School;

interface BillingProfile
{
    public function billingProfileId(): int;
    public function name(): string;
    public function email(): string;
    public function vatNumber(): string;
    public function tav(): string;

    public function address(): Address;
    public function school(): School;


}