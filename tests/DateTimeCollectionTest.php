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

    public function testMostRecent(): void
    {
        $datetime = DateTimeCollection::createAsList([
            new \DateTime('2021-01-01'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-05'),
        ])->mostRecent();

        self::assertEquals(new \DateTime('2021-01-05'), $datetime);
    }

    public function testOldest(): void
    {
        $datetime = DateTimeCollection::createAsList([
            new \DateTime('2021-01-01'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-05'),
        ])->oldest();

        self::assertEquals(new \DateTime('2021-01-01'), $datetime);
    }

    public function testDatesBetween(): void
    {
        $collection = DateTimeCollection::createAsList([
            new \DateTime('2021-01-01'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-05'),
        ]);

        $dates = $collection->between(new \DateTime('2021-01-02'), new \DateTime('2021-01-04'));

        self::assertSame(3, count($dates));
        self::assertEquals(new \DateTime('2021-01-02'), $dates[0]);
        self::assertEquals(new \DateTime('2021-01-03'), $dates[1]);
        self::assertEquals(new \DateTime('2021-01-04'), $dates[2]);
    }

    public function testDatesBefore(): void
    {
        $collection = DateTimeCollection::createAsList([
            new \DateTime('2021-01-01'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-05'),
        ]);

        $dates = $collection->before(new \DateTime('2021-01-03'));

        self::assertSame(2, count($dates));
        self::assertEquals(new \DateTime('2021-01-01'), $dates[0]);
        self::assertEquals(new \DateTime('2021-01-02'), $dates[1]);
    }

    public function testDatesAfter(): void
    {
        $collection = DateTimeCollection::createAsList([
            new \DateTime('2021-01-01'),
            new \DateTime('2021-01-02'),
            new \DateTime('2021-01-03'),
            new \DateTime('2021-01-04'),
            new \DateTime('2021-01-05'),
        ]);

        $dates = $collection->after(new \DateTime('2021-01-03'));

        self::assertSame(2, count($dates));
        self::assertEquals(new \DateTime('2021-01-04'), $dates[0]);
        self::assertEquals(new \DateTime('2021-01-05'), $dates[1]);
    }
}
