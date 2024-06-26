<?php
declare(strict_types=1);

namespace Atournayre\Collection;

/**
 * @template T
 * @extends AbstractCollection<T>
 */
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

    public function mostRecent(): \DateTimeInterface
    {
        return $this->sortDesc()->first();
    }

    public function oldest(): \DateTimeInterface
    {
        return $this->sortAsc()->first();
    }

    public function between(\DateTimeInterface $start, \DateTimeInterface $end): static
    {
        $clone = clone $this;
        $map = $clone
            ->toMap()
            ->filter(fn (\DateTimeInterface $date) => $date >= $start && $date <= $end)
            ->values()
        ;

        return static::fromMapAsList($map);
    }

    public function before(\DateTimeInterface $date): static
    {
        $clone = clone $this;
        $map = $clone
            ->toMap()
            ->filter(fn (\DateTimeInterface $d) => $d < $date)
            ->values()
        ;

        return static::fromMapAsList($map);
    }

    public function after(\DateTimeInterface $date): static
    {
        $clone = clone $this;
        $map = $clone
            ->toMap()
            ->filter(fn (\DateTimeInterface $d) => $d > $date)
            ->values()
        ;

        return static::fromMapAsList($map);
    }
}
