<?php

namespace App\Kohera\Purifier;

final class Purifier
{
    public object $subject;

    public function cleanAllFields(object $object): Object
    {
        return $object;
    }

    private function trimString(string $input): string
    {
        return trim($input);
    }
}