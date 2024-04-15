<?php

namespace Atournayre\Collection;

use Aimeos\Map;
use Atournayre\Assert\Assert;
use Doctrine\Common\Collections\ArrayCollection;

class TypedCollection extends AbstractCollection
{
    protected static string $type = 'string';

    public static function createAsList(array $collection): static
    {
        Assert::isListOf($collection, static::$type);
        return new static($collection);
    }

    public static function createAsMap(array $collection): static
    {
        Assert::isMapOf($collection, static::$type);
        return new static($collection);
    }

    public static function fromArrayCollectionToMap(ArrayCollection $collection): Map
    {
        $firstKey = current($collection->getKeys());

        if (is_string($firstKey)) {
            return self::createAsMap($collection->toArray())
                ->toMap();
        }

        return self::createAsList($collection->toArray())
            ->toMap();
    }

    public static function fromMapToArrayCollection(Map $collection): ArrayCollection
    {
        $firstKey = $collection->firstKey();

        if (is_string($firstKey)) {
            return self::createAsMap($collection->toArray())
                ->toArrayCollection();
        }

        return self::createAsList($collection->toArray())
            ->toArrayCollection();
    }
}
