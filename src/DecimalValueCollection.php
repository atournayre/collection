<?php

namespace Atournayre\Collection;

use Atournayre\Assert\Assert;
use Atournayre\Types\DecimalValue;

/**
 * @template T
 * @extends AbstractCollection<T>
 */
class DecimalValueCollection extends TypedCollection
{
    protected const DEFAULT_PRECISION = 0;

    protected static string $type = DecimalValue::class;

    public readonly int $precision;

    protected function __construct(
        protected array $collection = [],
        int $precision = self::DEFAULT_PRECISION
    )
    {
        Assert::allIsInstanceOf($collection, DecimalValue::class);
        Assert::allEq(
            array_map(fn(DecimalValue $value) => $value->precision, $collection),
            $precision
        );

        parent::__construct($collection);
        $this->precision = $precision;
    }

    public static function createAsList(array $collection, int $precision = self::DEFAULT_PRECISION): static
    {
        Assert::isListOf($collection, static::$type);
        return new self($collection, $precision);
    }

    public static function createAsMap(array $collection, int $precision = self::DEFAULT_PRECISION): static
    {
        Assert::isMapOf($collection, static::$type);
        return new self($collection, $precision);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->offsetSetAssertion($offset, $value);
        $this->collection[$offset] = DecimalValue::changePrecision($value, $this->precision);
    }

    public function add($value): self
    {
        $values = $this->collection;
        $values[] = DecimalValue::changePrecision($value, $this->precision);

        return new self($values, $value->precision);
    }

    /**
     * @return DecimalValue[]
     */
    public function values(): array
    {
        return $this->collection;
    }

    public function sum(): DecimalValue
    {
        if ($this->hasNoElement()) {
            return DecimalValue::create(0, $this->precision);
        }

        $sum = $this->toMap()
            ->map(fn (DecimalValue $value) => $value->value)
            ->sum();

        return DecimalValue::create($sum, $this->precision);
    }

    public function avg(): DecimalValue
    {
        if ($this->hasNoElement()) {
            return DecimalValue::create(0, $this->precision);
        }

        $avg = $this->toMap()
            ->map(fn (DecimalValue $value) => $value->value)
            ->avg();

        return DecimalValue::create($avg, $this->precision);
    }

    public function min(): DecimalValue
    {
        if ($this->hasNoElement()) {
            return DecimalValue::create(0, $this->precision);
        }

        $min = $this->toMap()
            ->map(fn (DecimalValue $value) => $value->value)
            ->min();

        return DecimalValue::create($min, $this->precision);
    }

    public function max(): DecimalValue
    {
        if ($this->hasNoElement()) {
            return DecimalValue::create(0, $this->precision);
        }

        $max = $this->toMap()
            ->map(fn (DecimalValue $value) => $value->value)
            ->max();

        return DecimalValue::create($max, $this->precision);
    }
}
