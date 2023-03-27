<?php

namespace Atournayre\Collection\Tests\Utils;

use Atournayre\Collection\TypedCollection;

class People extends TypedCollection
{
    protected static string $type = Person::class;
}
