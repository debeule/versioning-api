<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Facades\Http;

final class RetrieveFromSource
{
    public function handle(mixed $content, \Closure $next)
    {
        $content['file'] = Http::withOptions(['verify' => false])->get((string) $content['source'])->body();

        return $next($content);
    }
}