<?php

namespace Atournayre\Collection\Tests;

use Atournayre\Collection\Collection;
use Atournayre\Collection\CollectionImmutable;
use PHPUnit\Framework\TestCase;

class CollectionImmutableTest extends TestCase
{
    /**
     * @covers \Atournayre\Collection\CollectionImmutable::createAsList
     * @return void
     */
    public function testMutableList(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Collection is immutable');

        $collection = CollectionImmutable::createAsList('string', ['a']);
        $collection[] = 'd';
    }

    /**
     * @covers \Atournayre\Collection\CollectionImmutable::createAsList
     * @return void
     */
    public function testMutableMap(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Collection is immutable');

        $collection = CollectionImmutable::createAsMap('string', ['a' => 'a']);
        $collection['b'] = 'b';
    }

    /**
     * @covers \Atournayre\Collection\Collection::toArrayCollection
     * @return void
     */
    public function testListIsAnArrayCollection(): void
    {
        $collection = CollectionImmutable::createAsList('string', ['a']);
        $arrayCollection = $collection->toArrayCollection();
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $arrayCollection);
        static::assertIsInt($arrayCollection->key());
        static::assertEquals('a', $arrayCollection->current());
    }
}
