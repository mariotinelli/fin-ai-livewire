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

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Sora:wght@100..800&display=swap" rel="stylesheet" />

    @stack('styles')
    @vite('resources/css/app.css')
</head>

<body class="bg-base-200 font-sans text-base-content antialiased">
    <x-dev.bar />
    <x-ui.toast />
    <x-ui.loading />
    <x-ui.alert-modal />

    <main
        @class([
            'overflow-y-auto transition-all duration-300 ease-linear',
            'h-[calc(100dvh-var(--dev-bar-height))]' => withEnvBar(),
            'h-dvh' => !withEnvBar()
        ])
    >
        @if ($variant === 'centered')
            <div class="flex min-h-full items-center justify-center bg-primary p-4 sm:p-8">
                <div class="flex w-full max-w-lg flex-col items-center gap-8">
                    <x-ui.application-logo whiteHorizontal class="h-auto w-full max-w-xs sm:max-w-sm" />

                    <div class="w-full rounded-2xl border border-primary-content/20 bg-base-100 p-6 shadow-2xl sm:p-10">{{ $slot }}</div>
                </div>
            </div>
        @else
            <div class="grid min-h-full bg-base-100 lg:grid-cols-2">
                <div class="flex min-h-52 items-center justify-center bg-primary p-8 sm:min-h-64 lg:min-h-full lg:p-12">
                    <x-ui.application-logo whiteHorizontal class="h-auto w-full max-w-sm lg:max-w-xl" />
                </div>

                <div class="flex items-center justify-center bg-base-200 p-4 sm:p-8 lg:p-12">
                    <div class="w-full max-w-md rounded-2xl border border-base-300 bg-base-100 p-6 shadow-xl sm:p-10">{{ $slot }}</div>
                </div>
            </div>
        @endif
    </main>

    @vite('resources/js/app.js')
    <livewire:scripts />
    @stack('scripts')
</body>
</html>
