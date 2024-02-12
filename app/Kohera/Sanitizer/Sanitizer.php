<?php

declare(strict_types=1);

namespace App\Kohera\Sanitizer;

final class Sanitizer
{
    public object $subject;

    public function cleanAllFields(object $object): object
    {
        foreach ($object->getAttributes() as $key => $value) 
        {
            $object->{$key} = $this->cleanAttribute($value);
        }

        return $object;
    }

    private function cleanAttribute(string $input): string
    {
        $intput = trim($input);

        return $input;
    }
}