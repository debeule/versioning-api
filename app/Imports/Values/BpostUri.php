<?php

declare(strict_types=1);

namespace App\Imports\Values;

use League\Uri\Components\Query;
use League\Uri\Modifier;
use League\Uri\Uri;

final class BpostUri
{
    public string $value;

    public function __construct(
        private string $authority = 'www.bpost2.be',
        private string $path = '/zipcodes/files/zipcodes_alpha_nl_new.xls',
    ) {
        $this->value = (string) Uri::new($this->authority . $this->path);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}