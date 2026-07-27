@props(['user'])

<header class="sticky top-0 z-20 flex h-20 w-full items-center justify-between border-b border-slate-200/80 bg-white/80 px-4 sm:px-8 backdrop-blur-xl transition-all duration-300 dark:border-slate-800/80 dark:bg-slate-900/80">
    
    <!-- Left Section: Mobile Menu Toggle & Search Bar -->
    <div class="flex items-center gap-4 flex-1 max-w-xl">
        <!-- Mobile Sidebar Hamburger -->
        <button 
            @click="mobileSidebarOpen = true" 
            class="rounded-2xl border border-slate-200 p-2.5 text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Search Input -->
        <div class="relative w-full">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="text" 
                placeholder="Search courses, summaries, routines... (⌘K)" 
                class="w-full rounded-2xl border border-slate-200/80 bg-slate-50/70 py-2.5 pl-10 pr-12 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
            >
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <kbd class="hidden sm:inline-flex items-center rounded-lg border border-slate-200 bg-white px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 dark:border-slate-700 dark:bg-slate-800">⌘K</kbd>
            </div>
        </div>
    </div>

    <!-- Right Section: Actions, Notifications, Dark Mode & User Profile -->
    <div class="flex items-center gap-3">
        
        <!-- Dark Mode Toggle Button (UI Only) -->
        <button 
            @click="
                darkMode = !darkMode; 
                if (darkMode) { 
                    document.documentElement.classList.add('dark'); 
                    localStorage.setItem('color-theme', 'dark'); 
                } else { 
                    document.documentElement.classList.remove('dark'); 
                    localStorage.setItem('color-theme', 'light'); 
                }
            "
            type="button"
            class="relative flex size-11 items-center justify-center rounded-2xl border border-slate-200/80 bg-white text-slate-600 shadow-sm transition hover:border-indigo-300 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-800/80 dark:text-slate-300 dark:hover:border-slate-700 dark:hover:bg-slate-800"
            title="Toggle Dark Mode"
        >
            <!-- Sun icon when dark -->
            <svg x-show="darkMode" class="size-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <!-- Moon icon when light -->
            <svg x-show="!darkMode" class="size-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <!-- Notifications Dropdown Trigger -->
        <button 
            @click="currentTab = 'notifications'"
            type="button"
            class="relative flex size-11 items-center justify-center rounded-2xl border border-slate-200/80 bg-white text-slate-600 shadow-sm transition hover:border-indigo-300 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-800/80 dark:text-slate-300 dark:hover:border-slate-700 dark:hover:bg-slate-800"
            title="Notifications"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-2.5 right-2.5 flex size-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex size-2 rounded-full bg-indigo-600"></span>
            </span>
        </button>

        <!-- Vertical Separator -->
        <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>

        <!-- User Dropdown Menu -->
        <div x-data="{ userMenuOpen: false }" class="relative">
            <button 
                @click="userMenuOpen = !userMenuOpen"
                @click.away="userMenuOpen = false"
                class="flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white p-1.5 pr-3 shadow-sm transition hover:border-indigo-300 dark:border-slate-800 dark:bg-slate-800/80"
            >
                <img 
                    src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff' }}" 
                    alt="{{ $user->name }}" 
                    class="size-8 rounded-xl object-cover ring-2 ring-indigo-500/20"
                >
                <div class="hidden text-left sm:block">
                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-none truncate max-w-[120px]">{{ $user->name }}</p>
                    <span class="text-[10px] font-semibold text-indigo-600 dark:text-indigo-400">Pro Student</span>
                </div>
                <svg class="size-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': userMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Content Card -->
            <div 
                x-show="userMenuOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-3 w-56 rounded-2xl border border-slate-200/80 bg-white p-2 shadow-2xl backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900 z-50"
                style="display: none;"
            >
                <div class="px-3 py-2 border-b border-slate-100 dark:border-slate-800/80">
                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $user->name }}</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                </div>

                <div class="py-1 space-y-0.5">
                    <button 
                        @click="currentTab = 'profile'; userMenuOpen = false"
                        class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 transition"
                    >
                        <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        View Profile
                    </button>

                    <button 
                        @click="currentTab = 'settings'; userMenuOpen = false"
                        class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 transition"
                    >
                        <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                        Settings
                    </button>
                </div>

                <div class="pt-1 border-t border-slate-100 dark:border-slate-800/80">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button 
                            type="submit"
                            class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/30 transition"
                        >
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
