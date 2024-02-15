<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\School\Address;

interface BillingProfile
{
    public function firstName(): string;
    public function lastName(): string;
    public function email(): string;
    public function vatNumber(): string;
    public function tav(): string;

    public function address(): Address;
    public function school(): School;


}