<?php
declare(strict_types=1);

namespace Atournayre\Collection;

class DateTimeCollection extends TypedCollection
{
    protected static string $type = \DateTimeInterface::class;

    public function dates(): array
    {
        return $this->values();
    }

    public function sortAsc(): static
    {
        $clone = clone $this;
        $values = $clone->values();
        usort($values, fn (\DateTimeInterface $a, \DateTimeInterface $b) => $a <=> $b);

        return static::createAsList($values);
    }

    public function sortDesc(): static
    {
        $clone = clone $this;
        $values = $clone->values();
        usort($values, fn (\DateTimeInterface $a, \DateTimeInterface $b) => $b <=> $a);

        return static::createAsList($values);
    }
}
