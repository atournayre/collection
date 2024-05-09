<?php

namespace Atournayre\Collection;

/**
 * @template T
 * @extends AbstractCollection<T>
 */
class TypedCollectionImmutable extends TypedCollection
{
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \RuntimeException('Collection is immutable');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \RuntimeException('Collection is immutable');
    }
}
