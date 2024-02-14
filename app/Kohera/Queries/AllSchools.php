<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;

final class AllSchools
{
    public function query(): Builder
    {
        return School::query()
            ->select([
                'Name AS name',
                'Gangmaker_mail AS contact_email',
                'School_mail AS email',
                'address',
                'Student_Count AS student_count',
                'School_Id AS school_id',
                'Instellingsnummer AS institution_id',
                'type AS type',

                'Postcode AS postal_code',
            ]);
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}