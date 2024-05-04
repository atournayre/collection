<?php
declare(strict_types=1);

namespace Atournayre\Collection\Tests;

use Atournayre\Collection\DateTimeCollection;
use PHPUnit\Framework\TestCase;

class DateTimeCollectionTest extends TestCase
{
    public function testSortAsc(): void
    {
        $collection = DateTimeCollection::createAsList([
            new \DateTime('2021-01-05'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-01'),
        ])->sortAsc();

        self::assertSame(5, $collection->count());
        self::assertEquals(new \DateTime('2021-01-01'), $collection->first());
        self::assertEquals(new \DateTime('2021-01-05'), $collection->last());
    }

    public function testSortDesc(): void
    {
        $collection = DateTimeCollection::createAsList([
            new \DateTime('2021-01-01'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-05'),
        ])->sortDesc();

        self::assertSame(5, $collection->count());
        self::assertEquals(new \DateTime('2021-01-05'), $collection->first());
        self::assertEquals(new \DateTime('2021-01-01'), $collection->last());
    }
}
