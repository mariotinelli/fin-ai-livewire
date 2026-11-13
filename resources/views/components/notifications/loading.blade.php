<div x-show="loading" role="status" aria-label="Carregando notificações">
    <span class="sr-only">Carregando notificações...</span>
    <div aria-hidden="true" class="motion-safe:animate-pulse">
        @foreach (range(1, 5) as $row)
            <div class="flex h-32 flex-col gap-3 border-b border-base-300 p-4">
                <div class="h-4 w-3/4 rounded bg-base-300"></div>
                <div class="h-3 w-1/3 rounded bg-base-200"></div>
                <div class="h-3 w-full rounded bg-base-200"></div>
                <div class="h-3 w-4/5 rounded bg-base-200"></div>
            </div>
        @endforeach
    </div>
</div>
