<?php

declare(strict_types = 1);

namespace App\Livewire\Support\SystemErrorAlerts;

use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use App\Traits\Components\WithToast;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Show extends Component
{
    use WithToast;

    public SystemErrorAlert $systemErrorAlert;

    public function mount(SystemErrorAlert $systemErrorAlert): void
    {
        $this->authorize('view', $systemErrorAlert);

        $this->systemErrorAlert = $systemErrorAlert->load('user');
    }

    public function render(): View
    {
        return view('livewire.support.system-error-alerts.show');
    }

    public function acknowledge(): void
    {
        $this->authorize('update', $this->systemErrorAlert);

        $this->systemErrorAlert->update([
            'status' => SystemErrorAlertStatuses::Acknowledged,
        ]);

        $this->systemErrorAlert->refresh();
        $this->toast('Alerta marcado como reconhecido.');
    }

    public function resolve(): void
    {
        $this->authorize('update', $this->systemErrorAlert);

        $this->systemErrorAlert->update([
            'status' => SystemErrorAlertStatuses::Resolved,
        ]);

        $this->systemErrorAlert->refresh();
        $this->toast('Alerta marcado como resolvido.');
    }

    /** @return list<array<string, string>> */
    #[Computed]
    public function breadcrumb(): array
    {
        return [
            ['label' => 'Suporte'],
            ['label' => 'Alertas de Erro', 'route' => route('support.system-error-alerts.index')],
            ['label' => 'Detalhes'],
        ];
    }
}
