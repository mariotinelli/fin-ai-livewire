<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Blade;

it('serializes the step identifier for Alpine', function (): void {
    $stepId = <<<'PAYLOAD'
        account'; window.rsp53Executed = true; //
        PAYLOAD;

    $html = Blade::render('<x-ui.wizard.steps.content :id="$stepId">Conteúdo</x-ui.wizard.steps.content>', ['stepId' => $stepId]);

    expect($html)
        ->toContain('currentStep === \'account\\u0027; window.rsp53Executed = true; \\/\\/\'')
        ->not->toContain("currentStep === '{$stepId}'");
});
