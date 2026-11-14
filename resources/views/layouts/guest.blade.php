@props(['variant' => 'split'])

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="remsoft"
    data-application-title="{{ config('app.name', 'Laravel') }}"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if (config('app.robots.blocking') === true)
        <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
    @endif

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('assets/favicon.png') }}" />

    @stack('styles')
    @vite('resources/css/app.css')
</head>

<body class="flex h-dvh flex-col bg-base-200 font-sans text-base-content antialiased">
    <div
        class="[&>div]:h-auto! [&>div]:max-h-none! [&>div]:min-h-(--dev-bar-height) [&>div>div]:min-w-0 [&>div>div]:max-w-full [&>div>div]:overflow-x-auto shrink-0"
    >
        <x-dev.bar />
    </div>
    <x-ui.toast />
    <x-ui.loading />
    <x-ui.alert-modal />

    <main class="min-h-0 flex-1 overflow-y-auto bg-base-200">
        <div
            class="flex min-h-full flex-col items-center justify-center gap-6 px-4 py-8 pb-[max(2rem,env(safe-area-inset-bottom))] sm:gap-8 sm:px-8 sm:py-12"
        >
            <x-ui.application-logo class="h-auto w-36 shrink-0" />

            <div
                @class([
                    'w-full min-w-0 rounded-2xl border border-base-300 bg-base-100 p-6 shadow-panel sm:p-8 [&_button]:min-h-11 [&_.btn]:min-h-11 [&_.btn]:h-auto [&_.btn]:whitespace-normal [&_.btn]:py-3 [&_input]:border-base-300 [&_input[aria-invalid=true]]:border-error',
                    'max-w-lg' => $variant === 'centered',
                    'max-w-md' => $variant !== 'centered'
                ])
            >
                {{ $slot }}
            </div>
        </div>
    </main>

    @vite('resources/js/app.js')
    <livewire:scripts />
    @stack('scripts')
</body>
</html>
