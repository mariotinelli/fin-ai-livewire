<?php

declare(strict_types = 1);

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class BaseComponent extends Component
{
    /** @throws Throwable */
    public function transaction(callable $callback): void
    {
        DB::transaction(fn () => $callback());
    }

    #[On('validation-error')]
    public function addValidationError(string $field, string $message): void
    {
        $this->addError($field, $message);
    }

    #[On('clear-validation-errors')]
    public function clearValidationErrors(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
