<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'EduMentor AI') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-full bg-[#F8FAFC] text-slate-900 antialiased selection:bg-indigo-500 selection:text-white dark:bg-slate-950 dark:text-slate-100 font-sans">
        
        <div 
            x-data="{ 
                sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true', 
                mobileSidebarOpen: false,
                darkMode: (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
            }"
            x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebar_collapsed', value))"
            class="min-h-screen bg-[#F8FAFC] text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100"
        >
            <!-- Shared Collapsible Sidebar -->
            <x-dashboard.sidebar />

            <!-- Main Content Wrapper -->
            <div 
                :class="{
                    'lg:pl-64': !sidebarCollapsed,
                    'lg:pl-20': sidebarCollapsed
                }"
                class="flex flex-col min-h-screen transition-all duration-300"
            >
                <!-- Shared Topbar Navigation -->
                <x-dashboard.topbar :user="auth()->user()" />

                <!-- Scrollable Main Canvas -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
