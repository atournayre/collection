<?php

namespace Atournayre\Collection\Tests;

use Aimeos\Map;
use Atournayre\Collection\Tests\Utils\People;
use Atournayre\Collection\Tests\Utils\Person;
use Atournayre\Collection\TypedCollection;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class TypedCollectionTest extends TestCase
{
    /**
     * @covers \Atournayre\Collection\TypedCollection::createAsList
     * @return void
     */
    public function testMutableList(): void
    {
        $collection = TypedCollection::createAsList(['a']);
        $collection[] = 'd';
        static::assertCount(2, $collection);
    }

    /**
     * @covers \Atournayre\Collection\TypedCollection::createAsList
     * @return void
     */
    public function testMutableMap(): void
    {
        $collection = TypedCollection::createAsMap(['a' => 'a']);
        $collection['b'] = 'b';
        static::assertCount(2, $collection);
    }

    /**
     * @covers \Atournayre\Collection\TypedCollection::createAsList
     * @return void
     */
    public function testMutableListOfStringsThrowsExceptionIfOneElementIsNull(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected a string. Got: NULL');

        $collection = TypedCollection::createAsList(['a']);
        $collection[] = null;
    }

    /**
     * @covers \Atournayre\Collection\TypedCollection::createAsMap
     * @return void
     */
    public function testMutableMapOfStringsThrowsExceptionIfOneElementIsNull(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected a string. Got: NULL');

        $collection = TypedCollection::createAsMap(['a' => 'a']);
        $collection['b'] = null;
    }

    /**
     * @covers \Atournayre\Collection\TypedCollection::toArrayCollection
     * @return void
     */
    public function testListIsAnArrayCollection(): void
    {
        $collection = TypedCollection::createAsList(['a']);
        $arrayCollection = $collection->toArrayCollection();
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $arrayCollection);
        static::assertIsInt($arrayCollection->key());
        static::assertEquals('a', $arrayCollection->current());
    }

    /**
     * @covers \Atournayre\Collection\TypedCollection::toMap
     * @return void
     * @throws \Throwable
     */
    public function testListIsAMap(): void
    {
        $collection = TypedCollection::createAsList(['a']);
        $map = $collection->toMap();
        static::assertInstanceOf(Map::class, $map);
        static::assertIsInt($map->firstKey());
        static::assertEquals('a', $map->first());
    }

    public function testListIsAMapAndCanBeConvertedToArrayCollection(): void
    {
        $collection = TypedCollection::createAsList(['a', 'b']);
        $map = $collection->toMap();
        static::assertInstanceOf(Map::class, $map);
        static::assertEquals('a', $map->first());
    }

    public function testFromArrayCollectionToMapUsingList(): void
    {
        $arrayCollection = new \Doctrine\Common\Collections\ArrayCollection(['a', 'b']);
        $map = TypedCollection::fromArrayCollectionToMap($arrayCollection);
        static::assertInstanceOf(Map::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals(0, $map->firstKey());
    }

    public function testFromArrayCollectionToMapUsingMap(): void
    {
        $arrayCollection = new \Doctrine\Common\Collections\ArrayCollection(['a' => 'a', 'b' => 'b']);
        $map = TypedCollection::fromArrayCollectionToMap($arrayCollection);
        static::assertInstanceOf(Map::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals('a', $map->firstKey());
    }

    public function testFromMapToArrayCollectionUsingList(): void
    {
        $arrayCollection = new Map(['a', 'b']);
        $map = TypedCollection::fromMapToArrayCollection($arrayCollection);
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals(0, current($map->getKeys()));
    }

    public function testFromMapToArrayCollectionUsingMap(): void
    {
        $arrayCollection = new Map(['a' => 'a', 'b' => 'b']);
        $map = TypedCollection::fromMapToArrayCollection($arrayCollection);
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals('a', current($map->getKeys()));
    }
    public function testCreateCollectionOfPerson(): void
    {
        $taylor = new Person('Taylor');
        $jeffrey = new Person('Jeffrey');

        $people = People::createAsList([$taylor, $jeffrey]);

        static::assertCount(2, $people);
    }

    public function testCreateCollectionOfPersonWithAnError(): void
    {
        static::expectException(\InvalidArgumentException::class);

        $taylor = new Person('Taylor');
        $jeffrey = new Person('Jeffrey');

        $people = People::createAsList([$taylor, $jeffrey]);
        $people[] = new \stdClass();
    }
}
