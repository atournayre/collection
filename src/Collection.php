<?php

namespace Atournayre\Collection;

use Atournayre\Assert\Assert;
use Doctrine\Common\Collections\ArrayCollection;

class Collection implements \ArrayAccess, \Countable
{
    protected function __construct(
        private array $collection = []
    ) {
    }

    public static function createAsList(string $classOrType, array $collection): Collection
    {
        Assert::isListOf($collection, $classOrType);
        return new static($collection);
    }

    public static function createAsMap(string $classOrType, array $collection): Collection
    {
        Assert::isMapOf($collection, $classOrType);
        return new static($collection);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->collection);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->collection[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_string($offset)) {
            Assert::isMap($this->collection, 'Adding element to collection (list) using string key is not supported.');
        }
        if (is_int($offset)) {
            Assert::isList($this->collection, 'Adding element to collection (map) using integer key is not supported.');
        }

        $firstElement = reset($this->collection);

        if (\is_object($firstElement)) {
            Assert::isInstanceOf($value, \get_class($firstElement));
        } else {
            Assert::isType($value, \gettype($firstElement));
        }

        $this->collection[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->collection[$offset]);
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function toArrayCollection(): ArrayCollection
    {
        return new ArrayCollection($this->collection);
    }
}
