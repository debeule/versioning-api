<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Facades\Http;

final class RetrieveFromSource
{
    /** 
     * @return array<mixed> 
     * @param array<mixed> $content
    */
    public function handle(Array $content, \Closure $next): Array
    {
        $content['file'] = Http::withOptions(['verify' => false])->get((string) $content['source'])->body();

        return $next($content);
    }
}