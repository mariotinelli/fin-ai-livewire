@if (withEnvBar())
    <div
        class="sticky top-0 flex h-(--dev-bar-height) max-h-(--dev-bar-height) w-full flex-col items-center justify-center gap-2 bg-[#77c4ff] px-6 py-1 text-sm text-slate-600 sm:flex-row lg:justify-end"
    >
        <livewire:dev.env-bar />
        <livewire:dev.login />
    </div>
@endif
