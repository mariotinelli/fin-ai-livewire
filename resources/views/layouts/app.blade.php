<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="remsoft"
    data-application-title="FinAI"
    class="overflow-y-hidden"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if (config('app.robots.blocking') === true)
        <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
    @endif

    <title>FinAI</title>

    <link rel="icon" href="{{ asset('assets/finai-favicon.svg') }}" />

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative font-sans antialiased">
    <x-dev.bar />
    <x-ui.toast />
    <x-ui.loading />
    <x-ui.alert-modal />

    <div
        x-cloak
        @class([
            'bg-base-200 text-base-content',
            'min-h-[calc(100dvh-var(--dev-bar-height))]' => withEnvBar(),
            'min-h-dvh' => !withEnvBar()
        ])
        x-data="{
            asideOpen: localStorage.getItem('asideOpen') === 'true',
            mobileAsideOpen: false,
        }"
    >
        <x-ui.navbar />

        <div class="h-full">
            <livewire:sidebar />

            <x-ui.main> {{ $slot }} </x-ui.main>
        </div>
    </div>

    <livewire:scripts />
    @stack('scripts')
    @stack('modals')
</body>
</html>
