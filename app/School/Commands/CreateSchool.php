<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Imports\Queries\School;
use App\School\School as DbSchool;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateSchool
{
    use DispatchesJobs;

    public function __construct(
        public School $school
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->school)->save();
    }    

    private function buildRecord(School $school): DbSchool
    {        
        $newSchool = new DbSchool();
        
        $newSchool->record_id = $school->recordId();
        $newSchool->name = $school->name();
        $newSchool->email = $school->email();
        $newSchool->contact_email = $school->contactEmail();
        $newSchool->type = $school->type();
        $newSchool->school_number = $school->schoolNumber();
        $newSchool->institution_id = $school->institutionId();
        $newSchool->student_count = $school->studentCount();
        $newSchool->address_id = $school->address()->id;
        
        return $newSchool;
    }
}