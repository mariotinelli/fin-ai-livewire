@props(['title', 'description', 'actions' => null,])

<div class="mb-6 sm:flex sm:items-center sm:justify-between">
    <div class="sm:flex-auto">
        <h1 class="text-2xl leading-6 font-semibold text-primary">{{ $title }}</h1>
        <p class="mt-2 text-sm text-base-content">{{ $description }}</p>
    </div>

    @if ($actions)
        <div class="flex items-center gap-3">{{ $actions }}</div>
    @endif
</div>
