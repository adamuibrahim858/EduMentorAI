@props(['activeTab' => 'dashboard'])

@php
    $isOnDashboard = request()->routeIs('dashboard');
    $isOnCourses = request()->routeIs('courses.*');

    // Active & inactive CSS classes
    $activeClasses = 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25';
    $inactiveClasses = 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800/60 dark:hover:text-slate-100';
    $baseClasses = 'group relative flex w-full items-center gap-3.5 rounded-2xl px-3.5 py-3 text-sm font-semibold transition-all duration-200';
@endphp

<!-- Mobile Drawer Overlay backdrop -->
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

<!-- Main Sidebar Wrapper -->
<aside 
    :class="{
        'translate-x-0': mobileSidebarOpen,
        '-translate-x-full lg:translate-x-0': !mobileSidebarOpen,
        'lg:w-64': !sidebarCollapsed,
        'lg:w-20': sidebarCollapsed
    }"
    class="fixed top-0 bottom-0 left-0 z-50 flex flex-col border-r border-slate-200/80 bg-white/90 backdrop-blur-xl transition-all duration-300 dark:border-slate-800/80 dark:bg-slate-900/90 lg:z-30"
>
    <!-- Brand Header -->
    <div class="flex h-20 items-center justify-between px-5 border-b border-slate-100 dark:border-slate-800/60">
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

        <!-- Mobile Close Button -->
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
        
        {{-- ============================================ --}}
        {{-- Dashboard Home --}}
        {{-- On dashboard page: uses Alpine currentTab for highlighting --}}
        {{-- On other pages: always inactive (plain link) --}}
        {{-- ============================================ --}}
        @if($isOnDashboard)
            <button 
                @click="currentTab = 'dashboard'; mobileSidebarOpen = false"
                :class="{
                    '{{ $activeClasses }}': currentTab === 'dashboard',
                    '{{ $inactiveClasses }}': currentTab !== 'dashboard'
                }"
                class="{{ $baseClasses }}"
            >
        @else
            <a href="{{ route('dashboard') }}" class="{{ $baseClasses }} {{ $inactiveClasses }}">
        @endif
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Dashboard</span>
        @if($isOnDashboard)
            </button>
        @else
            </a>
        @endif

        {{-- ============================================ --}}
        {{-- Profile --}}
        {{-- ============================================ --}}
        @if($isOnDashboard)
            <button 
                @click="currentTab = 'profile'; mobileSidebarOpen = false"
                :class="{
                    '{{ $activeClasses }}': currentTab === 'profile',
                    '{{ $inactiveClasses }}': currentTab !== 'profile'
                }"
                class="{{ $baseClasses }}"
            >
        @else
            <a href="{{ route('dashboard') }}?tab=profile" class="{{ $baseClasses }} {{ $inactiveClasses }}">
        @endif
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Profile</span>
        @if($isOnDashboard)
            </button>
        @else
            </a>
        @endif

        {{-- ============================================ --}}
        {{-- Courses (dedicated route — always server-side active check) --}}
        {{-- ============================================ --}}
        <a 
            href="{{ route('courses.index') }}" 
            class="{{ $baseClasses }} {{ $isOnCourses ? $activeClasses : $inactiveClasses }}"
        >
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Courses</span>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="ml-auto rounded-full {{ $isOnCourses ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300' }} px-2 py-0.5 text-xs font-bold">
                {{ auth()->user() ? auth()->user()->courses()->count() : 0 }}
            </span>
        </a>

        {{-- ============================================ --}}
        {{-- Practice --}}
        {{-- ============================================ --}}
        @if($isOnDashboard)
            <button 
                @click="currentTab = 'practice'; mobileSidebarOpen = false"
                :class="{
                    '{{ $activeClasses }}': currentTab === 'practice',
                    '{{ $inactiveClasses }}': currentTab !== 'practice'
                }"
                class="{{ $baseClasses }}"
            >
        @else
            <a href="{{ route('dashboard') }}?tab=practice" class="{{ $baseClasses }} {{ $inactiveClasses }}">
        @endif
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Practice</span>
        @if($isOnDashboard)
            </button>
        @else
            </a>
        @endif

        {{-- ============================================ --}}
        {{-- Learning Routine --}}
        {{-- ============================================ --}}
        @if($isOnDashboard)
            <button 
                @click="currentTab = 'routine'; mobileSidebarOpen = false"
                :class="{
                    '{{ $activeClasses }}': currentTab === 'routine',
                    '{{ $inactiveClasses }}': currentTab !== 'routine'
                }"
                class="{{ $baseClasses }}"
            >
        @else
            <a href="{{ route('dashboard') }}?tab=routine" class="{{ $baseClasses }} {{ $inactiveClasses }}">
        @endif
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Learning Routine</span>
        @if($isOnDashboard)
            </button>
        @else
            </a>
        @endif

        {{-- ============================================ --}}
        {{-- Notifications --}}
        {{-- ============================================ --}}
        @if($isOnDashboard)
            <button 
                @click="currentTab = 'notifications'; mobileSidebarOpen = false"
                :class="{
                    '{{ $activeClasses }}': currentTab === 'notifications',
                    '{{ $inactiveClasses }}': currentTab !== 'notifications'
                }"
                class="{{ $baseClasses }}"
            >
        @else
            <a href="{{ route('dashboard') }}?tab=notifications" class="{{ $baseClasses }} {{ $inactiveClasses }}">
        @endif
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Notifications</span>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="ml-auto flex size-2 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
        @if($isOnDashboard)
            </button>
        @else
            </a>
        @endif

        <div class="my-4 border-t border-slate-200/80 dark:border-slate-800/80"></div>

        {{-- ============================================ --}}
        {{-- Settings --}}
        {{-- ============================================ --}}
        @if($isOnDashboard)
            <button 
                @click="currentTab = 'settings'; mobileSidebarOpen = false"
                :class="{
                    '{{ $activeClasses }}': currentTab === 'settings',
                    '{{ $inactiveClasses }}': currentTab !== 'settings'
                }"
                class="{{ $baseClasses }}"
            >
        @else
            <a href="{{ route('dashboard') }}?tab=settings" class="{{ $baseClasses }} {{ $inactiveClasses }}">
        @endif
            <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Settings</span>
        @if($isOnDashboard)
            </button>
        @else
            </a>
        @endif

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button 
                type="submit"
                class="group flex w-full items-center gap-3.5 rounded-2xl px-3.5 py-3 text-sm font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 dark:text-rose-400 dark:hover:bg-rose-950/30 transition-all duration-200"
            >
                <svg class="size-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Logout</span>
            </button>
        </form>
    </nav>

    <!-- Desktop Collapse Switch Footer -->
    <div class="hidden lg:flex items-center justify-between border-t border-slate-100 p-3.5 dark:border-slate-800/60">
        <button 
            @click="sidebarCollapsed = !sidebarCollapsed"
            class="flex w-full items-center justify-center gap-2 rounded-xl py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-slate-800 transition"
        >
            <svg class="size-5 transition-transform duration-300" :class="{ 'rotate-180': sidebarCollapsed }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Collapse Sidebar</span>
        </button>
    </div>
</aside>
