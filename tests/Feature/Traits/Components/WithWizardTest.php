<?php

declare(strict_types = 1);

use App\Traits\Components\WithWizard;

it('mounts and navigates wizard boundaries while validating forward movement', function (): void {
    $wizard = new class ([(object) ['id' => 'first'], (object) ['id' => 'last']]) {
        use WithWizard;

        public int $validations = 0;

        /** @param list<object{id: int|string}> $steps */
        public function __construct(public array $steps)
        {
        }

        public function validate(): void
        {
            $this->validations++;
        }
    };

    $wizard->mountWizard();
    $wizard->prevStep();
    $wizard->nextStep();
    $wizard->nextStep();
    $wizard->prevStep();

    expect($wizard->firstStep)->toBe('first')
        ->and($wizard->lastStep)->toBe('last')
        ->and($wizard->currentStep)->toBe('first')
        ->and($wizard->validations)->toBe(2);
});

it('honors an explicit current step with an empty definition', function (): void {
    $wizard = new class () {
        use WithWizard;

        /** @var list<object{id: int|string}> */
        public array $steps = [];

        public function validate(): void
        {
        }
    };

    $wizard->mountWizard('review');

    expect($wizard->firstStep)->toBeNull()
        ->and($wizard->lastStep)->toBeNull()
        ->and($wizard->currentStep)->toBe('review');
});
