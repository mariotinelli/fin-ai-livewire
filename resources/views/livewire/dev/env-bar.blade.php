<div class="flex items-center gap-x-2">
    <x-ui.badge md :label="$this->env" />

    @if ($this->branch !== null)
        <x-ui.badge md icon="branch"> {{ $this->branch }} </x-ui.badge>
    @endif
</div>
