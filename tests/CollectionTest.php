<?php

namespace Collection;

use Aimeos\Map;
use Atournayre\Collection\Collection;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class CollectionTest extends TestCase
{
    /**
     * @covers \Atournayre\Collection\Collection::createAsList
     * @return void
     */
    public function testMutableList(): void
    {
        $collection = Collection::createAsList('string', ['a']);
        $collection[] = 'd';
        static::assertCount(2, $collection);
    }

    /**
     * @covers \Atournayre\Collection\Collection::createAsList
     * @return void
     */
    public function testMutableMap(): void
    {
        $collection = Collection::createAsMap('string', ['a' => 'a']);
        $collection['b'] = 'b';
        static::assertCount(2, $collection);
    }

    /**
     * @covers \Atournayre\Collection\Collection::createAsList
     * @return void
     */
    public function testMutableListOfStringsThrowsExceptionIfOneElementIsNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a string. Got: NULL');

        $collection = Collection::createAsList('string', ['a']);
        $collection[] = null;
    }

    /**
     * @covers \Atournayre\Collection\Collection::createAsMap
     * @return void
     */
    public function testMutableMapOfStringsThrowsExceptionIfOneElementIsNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a string. Got: NULL');

        $collection = Collection::createAsMap('string', ['a' => 'a']);
        $collection['b'] = null;
    }

    /**
     * @covers \Atournayre\Collection\Collection::toArrayCollection
     * @return void
     */
    public function testListIsAnArrayCollection(): void
    {
        $collection = Collection::createAsList('string', ['a']);
        $arrayCollection = $collection->toArrayCollection();
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $arrayCollection);
        static::assertIsInt($arrayCollection->key());
        static::assertEquals('a', $arrayCollection->current());
    }

    /**
     * @covers \Atournayre\Collection\Collection::toMap
     * @return void
     * @throws \Throwable
     */
    public function testListIsAMap(): void
    {
        $collection = Collection::createAsList('string', ['a']);
        $map = $collection->toMap();
        static::assertInstanceOf(Map::class, $map);
        static::assertIsInt($map->firstKey());
        static::assertEquals('a', $map->first());
    }

    public function testListIsAMapAndCanBeConvertedToArrayCollection(): void
    {
        $collection = Collection::createAsList('string', ['a', 'b']);
        $map = $collection->toMap();
        static::assertInstanceOf(Map::class, $map);
        static::assertEquals('a', $map->first());
    }

    public function testFromArrayCollectionToMapUsingList(): void
    {
        $arrayCollection = new \Doctrine\Common\Collections\ArrayCollection(['a', 'b']);
        $map = Collection::fromArrayCollectionToMap($arrayCollection);
        static::assertInstanceOf(Map::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals(0, $map->firstKey());
    }

    public function testFromArrayCollectionToMapUsingMap(): void
    {
        $arrayCollection = new \Doctrine\Common\Collections\ArrayCollection(['a' => 'a', 'b' => 'b']);
        $map = Collection::fromArrayCollectionToMap($arrayCollection);
        static::assertInstanceOf(Map::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals('a', $map->firstKey());
    }

    public function testFromMapToArrayCollectionUsingList(): void
    {
        $arrayCollection = new Map(['a', 'b']);
        $map = Collection::fromMapToArrayCollection($arrayCollection);
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals(0, current($map->getKeys()));
    }

    public function testFromMapToArrayCollectionUsingMap(): void
    {
        $arrayCollection = new Map(['a' => 'a', 'b' => 'b']);
        $map = Collection::fromMapToArrayCollection($arrayCollection);
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $map);
        static::assertEquals('a', $map->first());
        static::assertEquals('a', current($map->getKeys()));
    }
}
