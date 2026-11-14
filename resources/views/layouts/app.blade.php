<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="remsoft" data-application-title="FinAI" class="overflow-y-hidden">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
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
            'finai-app bg-base-200 text-base-content md:grid md:h-(--app-height) md:grid-cols-[var(--closed-sidebar-width)_minmax(0,1fr)] md:bg-base-100 min-[64.0625rem]:data-[sidebar-expanded=true]:grid-cols-[var(--open-sidebar-width)_minmax(0,1fr)] [@media(1025px<=width<=1200px)]:[--open-sidebar-width:13rem]',
            'min-h-[calc(100dvh-var(--dev-bar-height))]' => withEnvBar(),
            'min-h-dvh' => !withEnvBar()
        ])
        x-data="sidebarLayout()"
        @resize.window="resize()"
        @focusin.window="if ($event.target !== document.body) focusedElement = $event.target;"
        :data-sidebar-expanded="asideOpen"
        @style(['--app-height: calc(100dvh - var(--dev-bar-height))' => withEnvBar(), '--app-height: 100dvh' => !withEnvBar()])
    >
        <livewire:sidebar />

        <div
            class="finai-workspace flex h-(--app-height) min-w-0 flex-col md:my-2 md:mr-2 md:h-[calc(var(--app-height)-1rem)] md:rounded-box md:border md:border-base-300 md:bg-base-200"
        >
            <x-ui.navbar />
            <x-ui.main> {{ $slot }} </x-ui.main>
        </div>
    </div>

    <livewire:scripts />
    @stack('scripts')
    @stack('modals')
</body>
</html>
