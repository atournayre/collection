<?php

namespace Collection;

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
}
