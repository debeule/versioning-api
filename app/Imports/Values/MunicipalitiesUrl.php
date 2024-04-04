<?php

declare(strict_types=1);

namespace App\Imports\Values;

use League\Uri\Uri;

final class MunicipalitiesUrl
{
    public string $value;

    public function __construct(
        private string $path = '/excel/',
        private string $fileName = 'municipalities.xls',
    ) {
        $this->value = (string) Uri::new($this->path . $this->fileName);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}