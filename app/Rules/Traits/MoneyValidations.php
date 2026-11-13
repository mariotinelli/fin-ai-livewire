<?php

declare(strict_types = 1);

namespace App\Rules\Traits;

use App\Enums\Rules;
use App\Rules\MoneyRule;
use App\Traits\Components\WithConverters;
use Closure;

trait MoneyValidations
{
    use WithConverters;

    /** @var array<string, array<string, float>>|null */
    protected ?array $rules = [];

    protected function checkValidations(string $attribute, string | int | float | null $value, Closure $fail): void
    {
        $rules = $this->correctOrderRules();

        foreach ($rules as $rule => $attributes) {
            $validation = match ($rule) {
                Rules::Between->value => fn () => $this->validateBetween($attribute, $value, $attributes, $fail),
                Rules::Min->value     => fn () => $this->validateMin($attribute, $value, $attributes, $fail),
                Rules::Max->value     => fn () => $this->validateMax($attribute, $value, $attributes, $fail),
                default               => null,
            };

            $validation?->__invoke();
        }
    }

    /**
     * Returns the validations in the correct order.
     * 1. Between
     * 2. Min
     * 3. Max
     * @return array<string, array<string, float>> */
    protected function correctOrderRules(): array
    {
        return collect($this->rules)
            ->sortBy(fn (array $value, string $key): int | false => array_search($key, Rules::moneyOrder(), true))
            ->all();
    }

    protected function hasRule(Rules $rule): bool
    {
        return isset($this->rules[$rule->value]);
    }

    /** @param array<string, float> $attributes */
    protected function addRule(Rules $rule, array $attributes = []): void
    {
        $this->rules[$rule->value] = $attributes;
    }

    /**
     * Adds a rule to validate if a value is a valid money.
     */
    public function default(): MoneyRule
    {
        $this->min(0);
        $this->max(9999999.99);

        return $this;
    }

    /**
     * Adds a rule to validate if a value is between the specified minimum and maximum.
     *
     * @param float $min The minimum value.
     * @param float $max The maximum value.
     */
    public function between(float $min, float $max): MoneyRule
    {
        $this->addRule(Rules::Between, [
            'min' => $min,
            'max' => $max,
        ]);

        return $this;
    }

    /**
     * Validates if a value is between the specified minimum and maximum.
     *
     * @param string $attribute The attribute being validated.
     * @param string|int|float|null $value The value being validated.
     * @param array<string, float> $attributes The attributes to be used in the validation.
     * @param Closure $fail The closure to be executed if the validation fails.
     */
    protected function validateBetween(string $attribute, string | int | float | null $value, array $attributes, Closure $fail): void
    {
        $min   = $attributes['min'];
        $max   = $attributes['max'];
        $value = $this->converterStringToFloat($value);

        if (!$this->hasRule(Rules::Required) && empty($value)) {
            return;
        }

        if ($value < $min || $value > $max) {
            $fail(trans('validation.between.numeric', [
                'min' => currency($min),
                'max' => currency($max),
            ]));
        }
    }

    /**
     * Adds a rule to validate if a value is greater than the specified minimum.
     *
     * @param float $min The minimum value.
     */
    public function min(float $min): MoneyRule
    {
        $this->addRule(Rules::Min, [
            'min' => $min,
        ]);

        return $this;
    }

    /**
     * Validates if a value is greater than the specified minimum.
     *
     * @param string $attribute The attribute being validated.
     * @param string|int|float|null $value The value being validated.
     * @param array<string, float> $attributes The attributes to be used in the validation.
     * @param Closure $fail The closure to be executed if the validation fails.
     */
    protected function validateMin(string $attribute, string | int | float | null $value, array $attributes, Closure $fail): void
    {
        $min   = $attributes['min'];
        $value = $this->converterStringToFloat($value);

        if (blank($value)) {
            return;
        }

        if ($value < $min) {
            $fail(trans('validation.min.numeric', ['min' => currency($min)]));
        }
    }

    /**
     * Adds a rule to validate if a value is less than the specified maximum.
     *
     * @param float $max The maximum value.
     */
    public function max(float $max = 9999999.99): MoneyRule
    {
        $this->addRule(Rules::Max, [
            'max' => $max,
        ]);

        return $this;
    }

    /**
     * Validates if a value is less than the specified maximum.
     *
     * @param string $attribute The attribute being validated.
     * @param string|int|float|null $value The value being validated.
     * @param array<string, float> $attributes The attributes to be used in the validation.
     * @param Closure $fail The closure to be executed if the validation fails.
     */
    protected function validateMax(string $attribute, string | int | float | null $value, array $attributes, Closure $fail): void
    {
        $max   = $attributes['max'];
        $value = $this->converterStringToFloat($value);

        if ($value > $max) {
            $fail(trans('validation.max.numeric', ['max' => currency($max)]));
        }
    }
}
