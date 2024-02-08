<?php 

namespace App\Schools\Commands;

use App\Schools\School;


final class CreateNewProvinceCommand
{
    public function __invoke(DwhSport $dwhSport): bool
    {
        $newSport = new Sport();

        $newSport->name = $dwhSport->Sport;

        return $newSport->save();
    }
}