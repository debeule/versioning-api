<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\Location\Municipality;
use App\School\Address as DbAdress;

interface Address
{
    public function recordId(): string;
    public function streetName(): string;
    public function streetIdentifier(): string;

    public function municipality(): Municipality;
    
    public function hasChanged(DbAdress $dbAdress): bool;
}