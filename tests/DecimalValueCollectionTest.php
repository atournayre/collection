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
        $collection = DecimalValueCollection::createAsList([DecimalValue::fromInt(1, 2)], 2);
        $newCollection = $collection->add(DecimalValue::fromInt(2, 2));
        self::assertCount(2, $newCollection->values());
    }

    public function testAddWithDifferentPrecision(): void
    {
        self::expectException(InvalidArgumentException::class);
        $collection = DecimalValueCollection::createAsList([DecimalValue::fromInt(1, 2)], 2);
        $collection->add(DecimalValue::fromInt(2, 3));
    }

    public function testSumWithDifferentPrecision(): void
    {
        self::expectException(InvalidArgumentException::class);
        $collection = DecimalValueCollection::createAsList(
            [
                DecimalValue::fromInt(1, 2),
                DecimalValue::fromInt(2, 3)
            ],
            2
        );
        $collection->sum();
    }

    public function testSumWithEmptyCollection(): void
    {
        $collection = DecimalValueCollection::createAsList([], 2);
        self::assertSame(0, $collection->sum()->value);
    }

    public function testSumWithOneElement(): void
    {
        $collection = DecimalValueCollection::createAsList([DecimalValue::fromInt(1, 2)], 2);
        self::assertSame(100, $collection->sum()->value);
        self::assertSame(1.00, $collection->sum()->toFloat());
        self::assertSame(2, $collection->sum()->precision);
    }

    public function testSumWithTwoElements(): void
    {
        $collection = DecimalValueCollection::createAsList(
            [
                DecimalValue::fromInt(1, 2),
                DecimalValue::fromInt(2, 2)
            ],
            2
        );
        self::assertSame(300, $collection->sum()->value);
        self::assertSame(3.00, $collection->sum()->toFloat());
        self::assertSame(2, $collection->sum()->precision);
    }

    public function testMin(): void
    {
        $collection = DecimalValueCollection::createAsList(
            [
                DecimalValue::fromInt(10, 2),
                DecimalValue::fromInt(2, 2),
                DecimalValue::fromInt(200, 2),
                DecimalValue::fromInt(20, 2),
            ],
            2
        );
        self::assertSame(2, $collection->min()->value);
    }

    public function testMax(): void
    {
        $collection = DecimalValueCollection::createAsList(
            [
                DecimalValue::fromInt(10, 2),
                DecimalValue::fromInt(2, 2),
                DecimalValue::fromInt(200, 2),
                DecimalValue::fromInt(20, 2),
            ],
            2
        );
        self::assertSame(200, $collection->max()->value);
    }

    public function testAvgWithEmptyCollection(): void
    {
        $collection = DecimalValueCollection::createAsList([], 2);
        self::assertSame(0, $collection->avg()->value);
    }

    public function testAvgWithOneElement(): void
    {
        $collection = DecimalValueCollection::createAsList([DecimalValue::fromInt(1, 2)], 2);
        self::assertSame(100, $collection->avg()->value);
        self::assertSame(1.00, $collection->avg()->toFloat());
        self::assertSame(2, $collection->avg()->precision);
    }

    public function testAvgWithTwoElements(): void
    {
        $collection = DecimalValueCollection::createAsList(
            [
                DecimalValue::fromInt(1, 2),
                DecimalValue::fromInt(2, 2)
            ],
            2
        );
        self::assertSame(150, $collection->avg()->value);
        self::assertSame(1.50, $collection->avg()->toFloat());
        self::assertSame(2, $collection->avg()->precision);
    }
}
