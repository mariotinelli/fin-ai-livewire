@use('App\Enums\SystemErrorAlertStatuses')

<x-ui.page title="Detalhes do Alerta" description="Visualize todas as informações da exceção registrada." :breadcrumb="$this->breadcrumb">
    <x-slot name="headerActions">
        <x-ui.button neutral sm href="{{ route('support.system-error-alerts.index') }}"> Voltar </x-ui.button>

        @can('update', $this->systemErrorAlert)
            @if ($this->systemErrorAlert->status === SystemErrorAlertStatuses::Open)
                <x-ui.button warning sm wire:click="acknowledge" loading="acknowledge"> Reconhecer </x-ui.button>
            @endif

            @if ($this->systemErrorAlert->status !== SystemErrorAlertStatuses::Resolved)
                <x-ui.button success sm wire:click="resolve" loading="resolve"> Resolver </x-ui.button>
            @endif
        @endcan
    </x-slot>

    <div class="grid min-w-0 gap-4 sm:gap-6">
        <x-ui.card divided header="Resumo técnico" heading-level="h2" class="min-w-0 rounded-2xl border border-base-300 sm:rounded-2xl!">
            <dl class="mb-6 flex flex-wrap gap-x-8 gap-y-4 rounded-lg bg-base-200 p-4">
                <div>
                    <dt class="mb-1 text-sm text-secondary">Status</dt>
                    <dd><x-ui.badge :color="$this->systemErrorAlert->status->color()">{{ $this->systemErrorAlert->status->label() }}</x-ui.badge></dd>
                </div>
                <div>
                    <dt class="mb-1 text-sm text-secondary">Severidade</dt>
                    <dd><x-ui.badge :color="$this->systemErrorAlert->severity->color()">{{ $this->systemErrorAlert->severity->label() }}</x-ui.badge></dd>
                </div>
            </dl>
            <div class="grid min-w-0 gap-x-8 gap-y-4 sm:grid-cols-2">
                <x-ui.details.card title="Ambiente" :value="$this->systemErrorAlert->environment" />
                <x-ui.details.card title="Ocorrências" :value="(string) $this->systemErrorAlert->occurrences" />
                <x-ui.details.card title="Primeira ocorrência" :value="$this->systemErrorAlert->first_seen_at?->format('d/m/Y H:i:s')" />
                <x-ui.details.card title="Última ocorrência" :value="$this->systemErrorAlert->last_seen_at?->format('d/m/Y H:i:s')" />
                <x-ui.details.card title="Exceção" :value="$this->systemErrorAlert->exception_class" />
                <x-ui.details.card
                    title="Local"
                    :value="($this->systemErrorAlert->file ?? 'N/A') . ':' . ($this->systemErrorAlert->line ?? 'N/A')"
                />
                <x-ui.details.card title="Rota" :value="$this->systemErrorAlert->route_name ?? 'N/A'" />
                <x-ui.details.card
                    title="Requisição"
                    :value="($this->systemErrorAlert->request_method ?? 'N/A') . ' ' . ($this->systemErrorAlert->request_url ?? 'N/A')"
                />
                <x-ui.details.card title="ID da Requisição" :value="$this->systemErrorAlert->request_id ?? 'N/A'" />
                <x-ui.details.card title="Usuário" :value="$this->systemErrorAlert->user?->email ?? 'Não autenticado'" />
            </div>
        </x-ui.card>

        <x-ui.card divided header="Mensagem da exceção" heading-level="h2" class="min-w-0 rounded-2xl border border-base-300 sm:rounded-2xl!">
            <p class="text-sm leading-relaxed wrap-anywhere whitespace-pre-wrap text-base-content">{{ $this->systemErrorAlert->message }}</p>
        </x-ui.card>

        <x-ui.card divided header="Contexto sanitizado" heading-level="h2" class="min-w-0 rounded-2xl border border-base-300 sm:rounded-2xl!">
            <pre
                tabindex="0" role="region" aria-label="Contexto sanitizado"
                class="max-h-80 overflow-auto rounded-lg bg-base-content p-4 font-mono text-sm leading-6 text-base-100 focus-visible:outline-2 focus-visible:outline-focus"
                >{{ json_encode($this->systemErrorAlert->context ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre
            >
        </x-ui.card>

        <x-ui.card divided header="Stack trace completo" heading-level="h2" class="min-w-0 rounded-2xl border border-base-300 sm:rounded-2xl!">
            <pre
                tabindex="0" role="region" aria-label="Stack trace completo"
                class="max-h-[32rem] overflow-auto rounded-lg bg-base-content p-4 font-mono text-sm leading-6 text-base-100 focus-visible:outline-2 focus-visible:outline-focus"
                >{{ $this->systemErrorAlert->trace }}</pre
            >
        </x-ui.card>
    </div>
</x-ui.page>
