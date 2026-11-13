<?php

declare(strict_types = 1);

namespace App\Traits\Components;

/**
 * @property-read list<object{id: int|string}> $steps
 */
trait WithWizard
{
    public mixed $currentStep = null;

    public mixed $firstStep = null;

    public mixed $lastStep = null;

    public function mountWizard(mixed $currentStep = null): void
    {
        $this->firstStep   = $this->steps[0]->id ?? null;
        $this->lastStep    = $this->steps[count($this->steps) - 1]->id ?? null;
        $this->currentStep = $currentStep ?? $this->firstStep;
    }

    public function nextStep(): void
    {
        $this->validate();

        if ($this->currentStep !== $this->lastStep) {
            $currentIndex      = collect($this->steps)->search(fn (object $step): bool => $step->id === $this->currentStep);
            $this->currentStep = $this->steps[$currentIndex + 1]->id ?? $this->lastStep;
        }
    }

    public function prevStep(): void
    {
        if ($this->currentStep !== $this->firstStep) {
            $currentIndex      = collect($this->steps)->search(fn (object $step): bool => $step->id === $this->currentStep);
            $this->currentStep = $this->steps[$currentIndex - 1]->id ?? $this->firstStep;
        }
    }
}
