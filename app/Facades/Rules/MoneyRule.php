<?php

declare(strict_types = 1);

namespace App\Facades\Rules;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Rules\MoneyRule
 * @method static MoneyRule default()
 * @method static MoneyRule between(float $min, float $max)
 * @method static MoneyRule min(float $min)
 * @method static MoneyRule max(float $max = 9999999.99)
 */
class MoneyRule extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Rules\MoneyRule::class;
    }
}
