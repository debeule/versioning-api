<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

final class RetrieveFromSource
{
    /** @param array<mixed> $content */
    /** @return array<mixed> */
    public function handle(Array $content, \Closure $next): Array
    {
        $content['file'] = Http::withOptions(['verify' => false])->get((string) $content['source'])->body();

        return $next($content);
    }
}