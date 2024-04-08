<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\Location\Municipality;

interface Address
{
    public function recordId(): string;
    public function streetName(): string;
    public function streetIdentifier(): string;

    public function municipality(): Municipality;
    
    public function hasChanged(): bool;
}