<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\BillingProfile as BillingProfileContract;

final class BillingProfile extends Model implements BillingProfileContract
{
    public function __construct(
        private School $school
    ) {}
    

}