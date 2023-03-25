<?php

namespace Atournayre\Collection;

use Atournayre\Assert\Assert;
use Atournayre\Types\DecimalValue;

class DecimalValueCollection
{
    private array $values;
    public readonly int $precision;

    protected function __construct(array $values, int $precision)
    {
        Assert::allIsInstanceOf($values, DecimalValue::class);
        Assert::allEq(
            array_map(fn(DecimalValue $value) => $value->precision, $values),
            $precision
        );

        $this->values = $values;
        $this->precision = $precision;
    }

    public static function fromArray(array $values, int $precision): self
    {
        return new self($values, $precision);
    }

    public function add(DecimalValue $value): self
    {
        $values = $this->values;
        $values[] = $value;

        return new self($values, $value->precision);
    }

    /**
     * @return DecimalValue[]
     */
    public function values(): array
    {
        return $this->values;
    }

    public function sum(): DecimalValue
    {
        $sum = 0;
        foreach ($this->values as $value) {
            $sum += $value->value;
        }

        return DecimalValue::fromInt($sum, $this->precision);
    }
}