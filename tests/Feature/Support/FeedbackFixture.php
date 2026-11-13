<?php

declare(strict_types = 1);

namespace Tests\Feature\Support;

use App\Enums\Toast;
use App\Traits\Components\WithAlert;
use App\Traits\Components\WithToast;
use Livewire\Component;

final class FeedbackFixture extends Component
{
    use WithAlert;
    use WithToast;

    public string $title = '';

    public ?string $description = null;

    public function showToast(bool $nextPage = false, bool $persistent = false, Toast $type = Toast::Success, int $time = 7): void
    {
        $this->toast($this->title, $this->description, $type, $time, $nextPage, $persistent);
    }

    public function showAlert(): void
    {
        $this->alert($this->title, $this->description);
    }

    public function showConfirmation(): void
    {
        $this->confirmAlert($this->title, $this->description, params: 42, textConfirm: $this->title, textCancel: $this->description);
    }

    public function showStyledConfirmation(): void
    {
        $this->confirmAlert($this->title, $this->description, params: 42, color: 'info', icon: 'information-circle', descriptionHighlight: $this->description);
    }

    public function render(): string
    {
        return '<div></div>';
    }
}
