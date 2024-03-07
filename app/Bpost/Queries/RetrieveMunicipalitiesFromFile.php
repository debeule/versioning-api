<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Municipality;
use App\Imports\Values\MunicipalitiesUri;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

final class RetrieveMunicipalitiesFromFile
{
    public function __construct(
        private MunicipalitiesUri $uri = new MunicipalitiesUri,
    ) {
    }

    public function query()
    {
        return Excel::toArray(new Request(), (string) $this->uri, null, \Maatwebsite\Excel\Excel::XLS);
    }

    public function get(): array
    {
        return $this->query()[0];
    }
}