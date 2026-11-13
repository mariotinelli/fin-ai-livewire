<?php

declare(strict_types = 1);

use App\Facades\BcMath as BcMathFacade;
use App\Support\BcMath as BcMathHelper;

it('resolves the facade root to BcMath helper', function (): void {
    expect(BcMathFacade::getFacadeRoot())->toBeInstanceOf(BcMathHelper::class);
});

it('proxies static calls to the underlying helper', function (): void {
    $result = BcMathFacade::make(10)
        ->add(2)
        ->sub(0.5);

    expect((string) $result)->toBe('11.50');
});
