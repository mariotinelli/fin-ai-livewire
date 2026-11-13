<?php

declare(strict_types = 1);

namespace App\Facades;

use App\Support\BcMath as BcMathHelper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static BcMathHelper make(float $value)
 */
class BcMath extends Facade
{
    #[\Override]
    protected static function getFacadeAccessor(): string
    {
        return BcMathHelper::class;
    }
}
