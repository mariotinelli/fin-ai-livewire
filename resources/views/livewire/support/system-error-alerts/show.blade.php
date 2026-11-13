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

    <div class="space-y-4">
        <x-ui.card divided header="Resumo técnico" description="Dados principais do alerta e da última ocorrência.">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-ui.details.card title="Status" :value="$this->systemErrorAlert->status->label()" />
                <x-ui.details.card title="Severidade" :value="$this->systemErrorAlert->severity->label()" />
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

        <x-ui.card divided header="Mensagem da exceção">
            <p class="text-sm whitespace-pre-wrap text-base-content">{{ $this->systemErrorAlert->message }}</p>
        </x-ui.card>

        <x-ui.card divided header="Contexto sanitizado">
            <pre
                class="max-h-80 overflow-auto rounded bg-neutral p-4 text-xs text-neutral-content"
                >{{ json_encode($this->systemErrorAlert->context ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre
            >
        </x-ui.card>

        <x-ui.card divided header="Stack trace completo">
            <pre
                class="max-h-[32rem] overflow-auto rounded bg-neutral p-4 text-xs text-neutral-content"
                >{{ $this->systemErrorAlert->trace }}</pre
            >
        </x-ui.card>
    </div>
</x-ui.page>
