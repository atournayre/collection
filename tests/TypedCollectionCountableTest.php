<?php

namespace Atournayre\Collection\Tests;

use Atournayre\Collection\TypedCollection;
use PHPUnit\Framework\TestCase;

class TypedCollectionCountableTest extends TestCase
{
    public function testAtLeastOneElement(): void
    {
        $collection = TypedCollection::createAsList(['a']);
        static::assertTrue($collection->atLeastOneElement());
    }

    public function testHasSeveralElements(): void
    {
        $collection = TypedCollection::createAsList(['a', 'b']);
        static::assertTrue($collection->atLeastOneElement());
        static::assertTrue($collection->hasSeveralElements());
    }

    public function testHasOneElement(): void
    {
        $collection = TypedCollection::createAsList(['a']);
        static::assertTrue($collection->hasOneElement());
        static::assertTrue($collection->atLeastOneElement());
        static::assertFalse($collection->hasSeveralElements());
    }

    public function testHasNoElement(): void
    {
        $collection = TypedCollection::createAsList([]);
        static::assertTrue($collection->hasNoElement());
        static::assertFalse($collection->hasOneElement());
        static::assertFalse($collection->atLeastOneElement());
        static::assertFalse($collection->hasSeveralElements());
    }

    public function testHasXElements(): void
    {
        $collection = TypedCollection::createAsList(['a', 'b', 'c']);
        static::assertFalse($collection->hasNoElement());
        static::assertFalse($collection->hasOneElement());
        static::assertTrue($collection->hasXElements(3));
    }
}
