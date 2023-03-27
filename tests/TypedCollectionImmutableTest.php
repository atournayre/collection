<?php

namespace Atournayre\Collection\Tests;

use Atournayre\Collection\Collection;
use Atournayre\Collection\TypedCollectionImmutable;
use PHPUnit\Framework\TestCase;

class TypedTypedCollectionImmutableTest extends TestCase
{
    /**
     * @covers \Atournayre\Collection\TypedCollectionImmutable::createAsList
     * @return void
     */
    public function testMutableList(): void
    {
        static::expectException(\RuntimeException::class);
        static::expectExceptionMessage('Collection is immutable');

        $collection = TypedCollectionImmutable::createAsList(['a']);
        $collection[] = 'd';
    }

    /**
     * @covers \Atournayre\Collection\TypedCollectionImmutable::createAsList
     * @return void
     */
    public function testMutableMap(): void
    {
        static::expectException(\RuntimeException::class);
        static::expectExceptionMessage('Collection is immutable');

        $collection = TypedCollectionImmutable::createAsMap(['a' => 'a']);
        $collection['b'] = 'b';
    }

    /**
     * @covers \Atournayre\Collection\Collection::toArrayCollection
     * @return void
     */
    public function testListIsAnArrayCollection(): void
    {
        $collection = TypedCollectionImmutable::createAsList(['a']);
        $arrayCollection = $collection->toArrayCollection();
        static::assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $arrayCollection);
        static::assertIsInt($arrayCollection->key());
        static::assertEquals('a', $arrayCollection->current());
    }
}
