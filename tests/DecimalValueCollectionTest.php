<?php

namespace Atournayre\Collection\Tests;

use Atournayre\Collection\DecimalValueCollection;
use Atournayre\Types\DecimalValue;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DecimalValueCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $collection = DecimalValueCollection::fromArray([DecimalValue::fromInt(1, 2)], 2);
        $newCollection = $collection->add(DecimalValue::fromInt(2, 2));
        $this->assertCount(2, $newCollection->values());
    }

    public function testAddWithDifferentPrecision(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $collection = DecimalValueCollection::fromArray([DecimalValue::fromInt(1, 2)], 2);
        $collection->add(DecimalValue::fromInt(2, 3));
    }

    public function testSum(): void
    {
        $collection = DecimalValueCollection::fromArray(
            [
                DecimalValue::fromInt(1, 2),
                DecimalValue::fromInt(2, 2)
            ],
            2
        );
        $this->assertSame(3, $collection->sum()->value);
    }

    public function testSumWithDifferentPrecision(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $collection = DecimalValueCollection::fromArray(
            [
                DecimalValue::fromInt(1, 2),
                DecimalValue::fromInt(2, 3)
            ],
            2
        );
        $collection->sum();
    }
}
