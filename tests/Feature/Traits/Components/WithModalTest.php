<?php

declare(strict_types = 1);

use App\Traits\Components\WithModal;

it('opens after clearing validation and closes the modal', function (): void {
    $component = new class () {
        use WithModal;

        public int $validationClears = 0;

        public function clearValidation(): void
        {
            $this->validationClears++;
        }
    };

    expect($component->modalOpen)->toBeFalse();

    $component->openModal();

    expect($component->modalOpen)->toBeTrue()
        ->and($component->validationClears)->toBe(1);

    $component->closeModal();

    expect($component->modalOpen)->toBeFalse()
        ->and($component->validationClears)->toBe(1);
});
