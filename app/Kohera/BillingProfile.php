<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Region extends Model
{
    public function __construct(
        private School $school
    ) {}
    
    
}