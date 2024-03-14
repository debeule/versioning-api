<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateSchool
{
    use DispatchesJobs;

    public function __construct(
        public KoheraSchool $koheraSchool
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->koheraSchool)->save();
    }    

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {        
        $newSchool = new School();
        
        $newSchool->record_id = $koheraSchool->recordId();
        $newSchool->name = $koheraSchool->name();
        $newSchool->email = $koheraSchool->email();
        $newSchool->contact_email = $koheraSchool->contactEmail();
        $newSchool->type = $koheraSchool->type();
        $newSchool->school_number = $koheraSchool->schoolNumber();
        $newSchool->institution_id = $koheraSchool->institutionId();
        $newSchool->student_count = $koheraSchool->studentCount();
        $newSchool->address_id = $koheraSchool->address()->id;
        
        return $newSchool;
    }
}