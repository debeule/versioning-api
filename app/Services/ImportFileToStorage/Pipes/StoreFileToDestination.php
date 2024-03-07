<?php

declare(strict_types=1);

namespace App\Services\ImportFileToStorage\Pipes;

use App\Imports\Values\MunicipalitiesUri;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class StoreFileToDestination
{
    public function handle(mixed $content, \Closure $next)
    {
        if (File::exists($content->destination)) File::delete($content->destination);

        Storage::disk('local')->put($content->destination, $content->file);

        return $next($content);
    }
}