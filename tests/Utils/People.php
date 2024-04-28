<?php

namespace Atournayre\Collection\Tests\Utils;

use Atournayre\Assert\Assert;
use Atournayre\Collection\TypedCollection;

class People extends TypedCollection
{
    protected static string $type = Person::class;

    protected function validateElement(mixed $value): void
    {
        Assert::lengthBetween($value->name, 1, 30);
    }
}
