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

                'Gemeente AS municipalityname',
                'Postcode AS postal_code',

                'Facturatie_Naam AS billing_profiles.name',
                'Facturatie_Tav AS billing_profiles.tav',
                'BTWNummer AS billing_profiles.vat_number',
                'Facturatie_Email AS billing_profiles.email',
                
                'Facturatie_Adres AS billing_profiles.address',

                'Facturatie_Postcode AS billing_profiles.municipality.postal_code',
                'Facturatie_Gemeente AS billing_profiles.municipalityname',
            ]);
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}