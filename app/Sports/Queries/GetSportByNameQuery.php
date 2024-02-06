<?php

namespace App\Sports\Queries;

use App\Models\Sport;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetSportByNameQuery
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __invoke(): ?Sport
    {
        try 
        {
            return Sport::where('name', $this->name)->firstOrFail();
        } 

        catch (\Throwable $th) 
        {
            return null;
        }
    }
}