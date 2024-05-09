<?php

namespace Atournayre\Collection;

use Aimeos\Map;
use Atournayre\Assert\Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template T
 */
abstract class AbstractCollection implements \ArrayAccess, \Countable
{
    protected function __construct(
        protected array $collection = []
    ) {
        foreach ($this->collection as $value) {
            $this->validateElement($value);
        }
        $this->validate();
    }

    abstract public static function createAsList(array $collection): AbstractCollection;

    abstract public static function createAsMap(array $collection): AbstractCollection;

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->collection);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->collection[$offset];
    }

    protected function offsetSetAssertion(mixed $offset, mixed $value): void
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
            return;
        }

        Assert::isType($value, \gettype($firstElement));
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->offsetSetAssertion($offset, $value);
        $this->collection[$offset] = $value;
    }

    public function add($value): self
    {
        $values = $this->collection;
        $values[] = $value;

        return new static($values);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->collection[$offset]);
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function values(): array
    {
        return $this->collection;
    }

    public function toArrayCollection(): ArrayCollection
    {
        return new ArrayCollection($this->collection);
    }

    public function toMap(): Map
    {
        return new Map($this->collection);
    }

    public function atLeastOneElement(): bool
    {
        return $this->count() > 0;
    }

    public function hasSeveralElements(): bool
    {
        return $this->count() > 1;
    }

    public function hasOneElement(): bool
    {
        return $this->hasXElements(1);
    }

    public function hasNoElement(): bool
    {
        return $this->hasXElements(0);
    }

    public function hasXElements(int $x): bool
    {
        return $this->count() === $x;
    }

    protected function validateElement(mixed $value): void
    {
        // Override this method in child class to add validation
    }

    protected function validate(): void
    {
        // Override this method in child class to add validation
    }

    public function first()
    {
        return reset($this->collection);
    }

    public function last()
    {
        return end($this->collection);
    }
}
