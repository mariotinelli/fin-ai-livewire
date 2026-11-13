<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="remsoft">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite('resources/css/app.css')
</head>

<body
    class="min-h-full max-w-screen bg-white font-sans text-black antialiased print:bg-white print:text-black"
    id="layout-pdf-4e67f255-3464-4cd3-a3ef-90bcb4b4879d"
>
    <div class="p-2">{{ $slot }}</div>
    @vite('resources/js/app.js')

    @stack('scripts')
    @stack('styles')
</body>
</html>
