<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class StoreFileToDestination
{
    /** 
     * @return array<mixed> 
     * @param array<mixed> $content
    */
    public function handle(Array $content, \Closure $next): Array
    {
        if (File::exists($content['destination'])) File::delete($content['destination']);

        Storage::disk('local')->put($content['destination'], $content['file']);
        
        return $next($content);
    }
}