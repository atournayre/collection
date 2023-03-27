<?php

namespace Atournayre\Collection;

use RuntimeException;

/**
 * @deprecated Use TypedCollectionImmutable instead
 */
class CollectionImmutable extends Collection implements \ArrayAccess, \Countable
{
    protected function __construct(
        private readonly array $collection = []
    ) {
        parent::__construct($collection);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new RuntimeException('Collection is immutable');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new RuntimeException('Collection is immutable');
    }
}
