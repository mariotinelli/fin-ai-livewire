<?php

declare(strict_types = 1);

use App\Traits\Components\WithSidepage;

it('opens and closes the sidepage', function (): void {
    $component = new class () {
        use WithSidepage;
    };

    expect($component->sidepageOpen)->toBeFalse();

    $component->openSidepage();

    expect($component->sidepageOpen)->toBeTrue();

    $component->closeSidepage();

    expect($component->sidepageOpen)->toBeFalse();
});
