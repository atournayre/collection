<?php

namespace Atournayre\Collection\Tests;

use Atournayre\Collection\DecimalValuePrecisionConsistentCollection;
use Atournayre\Types\DecimalValue;
use PHPUnit\Framework\TestCase;

class DecimalValuePrecisionConsistentCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $collection = DecimalValuePrecisionConsistentCollection::fromArray([DecimalValue::fromInt(1, 2)], 2);
        $newCollection = $collection->add(DecimalValue::fromInt(2, 3));
        $this->assertCount(2, $newCollection->values());
    }

    public function testSum(): void
    {
        $collection = DecimalValuePrecisionConsistentCollection::fromArray(
            [
                DecimalValue::fromInt(1, 2),
                DecimalValue::fromInt(2, 2)
            ],
            2
        );
        $this->assertSame(3, $collection->sum()->value);
    }
}
