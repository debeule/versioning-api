<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

final class StoreFileToDestination
{
    /** @param array<Mixed> $content */
    public function handle(Array $content, \Closure $next): Collection
    {
        if (File::exists($content['destination'])) File::delete($content['destination']);

        Storage::disk('local')->put($content['destination'], $content['file']);
        
        return $next($content);
    }
}