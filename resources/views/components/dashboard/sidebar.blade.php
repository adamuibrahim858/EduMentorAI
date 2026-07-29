@php
    $isOnDashboard     = request()->routeIs('dashboard');
    $isOnProfile       = request()->routeIs('profile*');
    $isOnCourses       = request()->routeIs('courses*');
    $isOnPractices     = request()->routeIs('practices*');
    $isOnProgress      = request()->routeIs('progress*');
    $isOnRoutine       = request()->routeIs('routine*') || request()->routeIs('routines*');

    $courseCount       = auth()->check() ? auth()->user()->courses()->count() : 0;

    // Active & inactive CSS styling
    $activeClasses   = 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25 dark:bg-indigo-600 dark:text-white';
    $inactiveClasses = 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800/60 dark:hover:text-slate-100';
    $baseClasses     = 'group relative flex w-full items-center gap-3.5 rounded-2xl px-3.5 py-3 text-sm font-semibold transition-all duration-200';
@endphp

<!-- Mobile Drawer Overlay Backdrop -->
<div 
    x-show="mobileSidebarOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="mobileSidebarOpen = false"
    class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"
    style="display: none;"
></div>

<!-- Main Sidebar Container -->
<aside 
    :class="{
        'translate-x-0': mobileSidebarOpen,
        '-translate-x-full lg:translate-x-0': !mobileSidebarOpen,
        'lg:w-64': !sidebarCollapsed,
        'lg:w-20': sidebarCollapsed
    }"
    class="fixed top-0 bottom-0 left-0 z-50 flex flex-col border-r border-slate-200/80 bg-white/95 backdrop-blur-xl transition-all duration-300 dark:border-slate-800/80 dark:bg-slate-900/95 lg:z-30"
>
    <!-- Brand Header -->
    <div class="flex h-20 items-center justify-between px-5 border-b border-slate-100 dark:border-slate-800/60 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="relative flex size-10 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-blue-500 text-white shadow-md shadow-indigo-500/20">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                </svg>
            </div>
            <div x-show="!sidebarCollapsed || mobileSidebarOpen" x-transition.opacity.duration.200ms class="flex flex-col whitespace-nowrap">
                <span class="text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">EduMentor <span class="text-indigo-600 dark:text-indigo-400">AI</span></span>
                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">PRO AI Companion</span>
            </div>
        </a>

        <!-- Mobile Drawer Close Button -->
        <button 
            @click="mobileSidebarOpen = false" 
            class="rounded-xl p-1.5 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 lg:hidden"
        >
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1.5">

        {{-- 1. Dashboard --}}
        <a 
            href="{{ route('dashboard') }}" 
            class="{{ $baseClasses }} {{ $isOnDashboard ? $activeClasses : $inactiveClasses }}"
            title="Dashboard"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Dashboard</span>
        </a>

        {{-- 2. Profile --}}
        <a 
            href="{{ route('profile') }}" 
            class="{{ $baseClasses }} {{ $isOnProfile ? $activeClasses : $inactiveClasses }}"
            title="Profile"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Profile</span>
        </a>

        {{-- 3. Courses --}}
        <a 
            href="{{ route('courses.index') }}" 
            class="{{ $baseClasses }} {{ $isOnCourses ? $activeClasses : $inactiveClasses }}"
            title="Courses"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Courses</span>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="ml-auto rounded-full {{ $isOnCourses ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300' }} px-2 py-0.5 text-xs font-bold">
                {{ $courseCount }}
            </span>
        </a>

        {{-- 4. Practices --}}
        <a 
            href="{{ route('practices.index') }}" 
            class="{{ $baseClasses }} {{ $isOnPractices ? $activeClasses : $inactiveClasses }}"
            title="Practices"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Practices</span>
        </a>

        {{-- 5. Academic Progress --}}
        <a 
            href="{{ route('progress.index') }}" 
            class="{{ $baseClasses }} {{ $isOnProgress ? $activeClasses : $inactiveClasses }}"
            title="Academic Progress"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Academic Progress</span>
        </a>

        {{-- 6. Learning Routines --}}
        <a 
            href="{{ route('routine') }}" 
            class="{{ $baseClasses }} {{ $isOnRoutine ? $activeClasses : $inactiveClasses }}"
            title="Learning Routines"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Learning Routines</span>
        </a>
    </nav>

    {{-- AI Assistant CTA — sits above the Collapse Sidebar footer --}}
    <div class="px-3 pb-3 shrink-0 border-t border-slate-100 dark:border-slate-800/60 pt-3">

        {{-- Expanded state: full-width pill button --}}
        <a
            x-show="!sidebarCollapsed || mobileSidebarOpen"
            href="{{ route('chat.assistant') }}"
            class="relative flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200 overflow-hidden
                {{ request()->routeIs('chat.*')
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
                    : 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-purple-700 hover:-translate-y-0.5 active:translate-y-0' }}"
            title="AI Assistant"
        >
            {{-- Shimmer overlay --}}
            <span class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent)] pointer-events-none"></span>

            {{-- Sparkle icon --}}
            <span class="relative flex size-8 shrink-0 items-center justify-center rounded-xl bg-white/20">
                <svg class="size-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
            </span>

            <span class="relative flex-1 text-left">
                <span class="block text-xs font-extrabold leading-tight">EduMentor AI</span>
                <span class="block text-[10px] font-medium text-indigo-200 leading-tight">Ask me anything</span>
            </span>

            {{-- Sparkle badge --}}
            <svg class="relative size-4 text-amber-300 animate-pulse shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2z"/>
            </svg>
        </a>

        {{-- Collapsed state: icon-only circle button --}}
        <a
            x-show="sidebarCollapsed && !mobileSidebarOpen"
            href="{{ route('chat.assistant') }}"
            class="relative flex size-[44px] mx-auto items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-110 active:scale-95 transition-all duration-200"
            title="AI Assistant"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
            </svg>
            <span class="absolute -top-1 -right-1 size-3 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-slate-900"></span>
        </a>
    </div>

    <!-- Desktop Collapse Toggle Button Footer -->
    <div class="hidden lg:flex items-center justify-between border-t border-slate-100 p-3.5 dark:border-slate-800/60 shrink-0">
        <button 
            @click="sidebarCollapsed = !sidebarCollapsed"
            class="flex w-full items-center justify-center gap-2 rounded-xl py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-slate-800 transition"
            title="Toggle Sidebar Collapse"
        >
            <svg class="size-5 transition-transform duration-300" :class="{ 'rotate-180': sidebarCollapsed }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Collapse Sidebar</span>
        </button>
    </div>
</aside>
