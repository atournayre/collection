<?php

namespace Atournayre\Collection;

use Aimeos\Map;
use Atournayre\Assert\Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template T
 * @extends AbstractCollection<T>
 */
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

    public static function fromMapAsMap(Map $map): static
    {
        return self::createAsMap($map->toArray());
    }

    public function isMap(): bool
    {
        return is_string($this->firstKey());
    }

    public function firstKey(): int|string
    {
        return current($this->getKeys());
    }

    public function getKeys(): array
    {
        return array_keys($this->collection);
    }

    public function isList(): bool
    {
        return is_int($this->firstKey());
    }

    public static function fromMapAsList(Map $map): static
    {
        return self::createAsList($map->toArray());
    }
}
