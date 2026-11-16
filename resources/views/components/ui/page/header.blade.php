@props(['title', 'description', 'actions' => null,])

<div class="mb-6 flex min-w-0 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="min-w-0 sm:flex-auto">
        <h1 class="font-display text-3xl leading-tight text-base-content sm:text-4xl">{{ $title }}</h1>
        <p class="mt-2 text-sm leading-relaxed text-secondary">{{ $description }}</p>
    </div>

    @if ($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-3">{{ $actions }}</div>
    @endif
</div>
