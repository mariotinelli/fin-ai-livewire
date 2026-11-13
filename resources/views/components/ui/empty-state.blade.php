@props(['title', 'description' => null,])

<div {{ $attributes->class(['flex w-full flex-col items-center justify-center gap-3 px-4 py-8 text-center sm:px-6']) }}>
    <div role="status" aria-live="polite" aria-atomic="true" class="flex max-w-sm flex-col items-center gap-2">
        <span class="flex size-9 items-center justify-center rounded-full bg-base-200 text-base-content/65" aria-hidden="true">
            <x-icons.inbox-stack class="size-5" aria-hidden="true" />
        </span>

        <div class="flex flex-col gap-1">
            <p class="text-sm font-semibold text-base-content">{{ $title }}</p>

            @if ($description)
                <p class="text-sm text-base-content/65">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if ($slot->hasActualContent())
        <div>{{ $slot }}</div>
    @endif
</div>
