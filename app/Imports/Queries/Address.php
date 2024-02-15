<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\School\Municipalities;

interface Address
{
    public function streetName(): string;
    public function streetIdentifier(): string;

    public function municipality(): Municipalities;
}