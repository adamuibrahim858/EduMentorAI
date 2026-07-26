<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Authentication' }} - {{ config('app.name', 'EduMentor AI') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full bg-slate-100 text-slate-950 antialiased dark:bg-slate-950 dark:text-white">
        <main class="min-h-full overflow-hidden">
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
