<?php

declare(strict_types = 1);

namespace App\Support;

class BcMath implements \Stringable
{
    /** @var numeric-string */
    protected string $value = '0';

    protected int $scale = 2;

    public function make(string | int | float $value = 0, int $scale = 2): self
    {
        $self        = new self();
        $self->value = $this->numericValue($value);
        $self->scale = $scale;

        return $self;
    }

    public function add(string | int | float $value, ?int $scale = null): self
    {
        $this->value = bcadd($this->value, $this->numericValue($value), $scale ?: $this->scale);

        return $this;
    }

    public function sub(string | int | float $value, ?int $scale = null): self
    {
        $this->value = bcsub($this->value, $this->numericValue($value), $scale ?: $this->scale);

        return $this;
    }

    public function mul(string | int | float $value, ?int $scale = null): self
    {
        $this->value = bcmul($this->value, $this->numericValue($value), $scale ?: $this->scale);

        return $this;
    }

    public function div(string | int | float $value, ?int $scale = null): self
    {
        $this->value = bcdiv($this->value, $this->numericValue($value), $scale ?: $this->scale);

        return $this;
    }

    public function percentage(string | int | float $value, ?int $scale = null): self
    {
        $this->value = $this->calculatePercentage($value, $scale);

        return $this;
    }

    public function tax(string | int | float $value, ?int $scale = null): self
    {
        $percentage = $this->calculatePercentage($value, $scale);

        $this->value = bcadd($this->value, $percentage, $scale ?: $this->scale);

        return $this;
    }

    /** @return numeric-string */
    protected function calculatePercentage(string | int | float $value, ?int $scale): string
    {
        $number = $this->numericValue($value);

        return bcmul($this->value, $this->numericValue($number / 100), $scale ?: $this->scale);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }

    public function toInt(): int
    {
        $powerOfTen = 1;

        for ($i = 0; $i < $this->scale; $i++) {
            $powerOfTen *= 10;
        }

        return (int) bcmul($this->value, (string) $powerOfTen, 0);
    }

    /** @return numeric-string */
    private function numericValue(string | int | float $value): string
    {
        $number = (string) $value;

        if (!is_numeric($number)) {
            throw new \ValueError('Invalid numeric value');
        }

        return $number;
    }
}
