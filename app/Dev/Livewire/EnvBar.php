<?php

declare(strict_types = 1);

namespace App\Dev\Livewire;

use App\Enums\ApplicationEnvironments;
use Illuminate\Support\Facades\Process;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EnvBar extends Component
{
    public function render(): View
    {
        return view('livewire.dev.env-bar');
    }

    #[Computed]
    public function env(): string
    {
        return applicationEnvironment()->value;
    }

    #[Computed]
    public function branch(): ?string
    {
        if (applicationEnvironment() === ApplicationEnvironments::Local) {
            $result = Process::path(base_path())->run('git branch --show-current');

            return $result->successful() ? trim($result->output()) : '';
        }

        return null;
    }
}
