<div 
    x-data="{ 
        currentTab: 'courses',
        activeTab: @entangle('activeTab'),
        sidebarCollapsed: false, 
        mobileSidebarOpen: false,
        darkMode: (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
    }" 
    class="min-h-screen bg-[#F8FAFC] text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100"
    wire:poll.5s
>
    <!-- Collapsible Responsive Sidebar Component -->
    <x-dashboard.sidebar :active-tab="'courses'" />

    <!-- Main Content Area Wrapper -->
    <div 
        :class="{
            'lg:pl-64': !sidebarCollapsed,
            'lg:pl-20': sidebarCollapsed
        }"
        class="flex flex-col min-h-screen transition-all duration-300"
    >
        <!-- Sticky Topbar Navigation Component -->
        <x-dashboard.topbar :user="auth()->user()" />

        <!-- Main Scrollable Content Canvas -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-8">
            
            @if(session()->has('message'))
                <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 dark:bg-emerald-950/50 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="size-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 dark:bg-rose-950/50 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="size-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Navigation Back Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to All Courses
                </a>

                <div class="flex items-center gap-2">
                    <button 
                        wire:click="$set('showEditCourseModal', true)" 
                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 transition"
                    >
                        <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Course
                    </button>
                </div>
            </div>

            <!-- Flash Alert -->
            @if (session()->has('message'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/40 dark:border-emerald-800 p-4 text-sm font-semibold text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
                    <span class="flex items-center gap-2">
                        <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ session('message') }}
                    </span>
                    <button @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400">&times;</button>
                </div>
            @endif

            <!-- HEADER BANNER -->
            <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-gradient-to-br from-indigo-900 via-slate-900 to-indigo-950 p-6 sm:p-10 text-white shadow-xl dark:border-slate-800">
                <div class="absolute -right-20 -top-20 size-80 rounded-full bg-indigo-500/20 blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 size-80 rounded-full bg-purple-500/20 blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="space-y-3 max-w-3xl">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-extrabold bg-indigo-500/25 border border-indigo-400/30 text-indigo-200 uppercase tracking-wider backdrop-blur-md">
                                {{ $course->course_code }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-white/10 border border-white/15 text-slate-200 backdrop-blur-md">
                                <svg class="size-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $course->semester }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-white/10 border border-white/15 text-slate-200 backdrop-blur-md">
                                {{ $course->course_unit }} Credit Units
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $course->status === 'active' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                                <span class="size-1.5 rounded-full {{ $course->status === 'active' ? 'bg-emerald-400 animate-ping' : 'bg-amber-400' }}"></span>
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white">
                            {{ $course->course_title }}
                        </h1>

                        @if($course->description)
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl">
                                {{ $course->description }}
                            </p>
                        @endif
                    </div>

                    <!-- Course Progress Indicator Card -->
                    <div class="shrink-0 w-full lg:w-72 rounded-2xl bg-white/10 border border-white/15 p-5 backdrop-blur-md space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-300 uppercase tracking-wider">AI Processing Progress</span>
                            <span class="text-indigo-300 font-extrabold text-sm">{{ $progressPercent }}%</span>
                        </div>

                        <div class="w-full bg-slate-900/60 rounded-full h-3 overflow-hidden p-0.5 border border-white/10">
                            <div 
                                class="bg-gradient-to-r from-indigo-400 to-emerald-400 h-full rounded-full transition-all duration-500 shadow-sm"
                                style="width: {{ $progressPercent }}%"
                            ></div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-slate-300">
                            <span>PDFs Processed:</span>
                            <span class="font-bold text-white">{{ $completedMaterials }} / {{ $totalMaterials }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABS NAVIGATION HEADER -->
            <div class="border-b border-slate-200 dark:border-slate-800">
                <nav class="-mb-px flex space-x-2 sm:space-x-8 overflow-x-auto no-scrollbar">
                    
                    <!-- Overview -->
                    <button 
                        @click="activeTab = 'overview'" 
                        :class="{ 
                            'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === 'overview',
                            'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== 'overview' 
                        }"
                        class="group inline-flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-xs sm:text-sm font-bold transition-all duration-200"
                    >
                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Overview
                    </button>

                    <!-- Course Materials -->
                    <button 
                        @click="activeTab = 'materials'" 
                        :class="{ 
                            'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === 'materials',
                            'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== 'materials' 
                        }"
                        class="group inline-flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-xs sm:text-sm font-bold transition-all duration-200"
                    >
                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Course Materials
                        <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[10px] font-bold text-slate-600 dark:text-slate-400">
                            {{ $course->materials->count() }}
                        </span>
                    </button>

                    <!-- Past Questions -->
                    <button 
                        @click="activeTab = 'past_questions'" 
                        :class="{ 
                            'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === 'past_questions',
                            'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== 'past_questions' 
                        }"
                        class="group inline-flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-xs sm:text-sm font-bold transition-all duration-200"
                    >
                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Past Questions
                        <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[10px] font-bold text-slate-600 dark:text-slate-400">
                            {{ $course->pastQuestions->count() }}
                        </span>
                    </button>

                    <!-- Lecturer -->
                    <button 
                        @click="activeTab = 'lecturer'" 
                        :class="{ 
                            'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === 'lecturer',
                            'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== 'lecturer' 
                        }"
                        class="group inline-flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-xs sm:text-sm font-bold transition-all duration-200"
                    >
                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Lecturer
                        @if($course->lecturer)
                            <span class="size-2 rounded-full bg-emerald-500"></span>
                        @endif
                    </button>

                    <!-- AI Summaries -->
                    <button 
                        @click="activeTab = 'summaries'" 
                        :class="{ 
                            'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === 'summaries',
                            'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== 'summaries' 
                        }"
                        class="group inline-flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-xs sm:text-sm font-bold transition-all duration-200"
                    >
                        <svg class="size-4 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                        </svg>
                        AI Summaries
                        <span class="rounded-full bg-indigo-100 dark:bg-indigo-950 px-2 py-0.5 text-[10px] font-bold text-indigo-700 dark:text-indigo-300">
                            {{ $course->summaries->count() }}
                        </span>
                    </button>

                    <!-- Future Practice -->
                    <button 
                        @click="activeTab = 'future_practice'" 
                        :class="{ 
                            'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === 'future_practice',
                            'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== 'future_practice' 
                        }"
                        class="group inline-flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-xs sm:text-sm font-bold transition-all duration-200"
                    >
                        <svg class="size-4 shrink-0 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Future Practice
                    </button>

                </nav>
            </div>

            <!-- TAB 1: OVERVIEW TAB -->
            <div x-show="activeTab === 'overview'" class="space-y-8">
                <!-- 5 Statistics Cards -->
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <!-- Total PDFs -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Total PDFs</span>
                            <div class="size-9 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 flex items-center justify-center">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">{{ $course->materials->count() }}</div>
                        <p class="text-[11px] text-slate-400 mt-1">Uploaded course materials</p>
                    </div>

                    <!-- Past Questions -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Past Questions</span>
                            <div class="size-9 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-950/60 dark:text-purple-400 flex items-center justify-center">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">{{ $course->pastQuestions->count() }}</div>
                        <p class="text-[11px] text-slate-400 mt-1">Exam papers ready for AI</p>
                    </div>

                    <!-- Generated Summaries -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">AI Summaries</span>
                            <div class="size-9 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 flex items-center justify-center">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">{{ $course->summaries->count() }}</div>
                        <p class="text-[11px] text-slate-400 mt-1">Gemma AI summaries</p>
                    </div>

                    <!-- Generated Practices -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Practices</span>
                            <div class="size-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">Ready</div>
                        <p class="text-[11px] text-slate-400 mt-1">Adaptive engine ready</p>
                    </div>

                    <!-- Last Updated -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Last Updated</span>
                            <div class="size-9 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 flex items-center justify-center">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-sm font-bold text-slate-900 dark:text-white mt-2">{{ $course->updated_at->diffForHumans() }}</div>
                        <p class="text-[11px] text-slate-400 mt-1">{{ $course->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Overview Quick Actions & Recent Uploads -->
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <svg class="size-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Recent PDF Materials
                            </h3>
                            <button @click="activeTab = 'materials'" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">View All &rarr;</button>
                        </div>

                        @if($course->materials->count() > 0)
                            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($course->materials->take(4) as $mat)
                                    <div class="py-3 flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="size-9 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                                                <svg class="size-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="overflow-hidden">
                                                <div class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $mat->title }}</div>
                                                <div class="text-[11px] text-slate-400">{{ number_format(($mat->file_size ?: 0) / 1024, 1) }} KB &bull; {{ $mat->pages ?: '?' }} pages &bull; {{ $mat->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>

                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold 
                                            @if($mat->status === 'completed') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400
                                            @elseif($mat->status === 'failed') bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-400
                                            @else bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400 animate-pulse
                                            @endif
                                        ">
                                            {{ ucfirst(str_replace('_', ' ', $mat->status)) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 py-6 text-center">No PDF materials uploaded yet for this course.</p>
                        @endif
                    </div>

                    <!-- Quick Action Panel -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 space-y-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Quick Actions</h3>
                        
                        <button 
                            wire:click="$set('showMaterialUploadModal', true)" 
                            class="w-full flex items-center justify-between p-3.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:hover:bg-indigo-950 border border-indigo-200/60 dark:border-indigo-800 transition"
                        >
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">Upload PDF Material</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400">Triggers AI summary job</div>
                                </div>
                            </div>
                            <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <button 
                            @click="activeTab = 'lecturer'" 
                            class="w-full flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/40 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 transition"
                        >
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-xl bg-purple-600 text-white flex items-center justify-center">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">Configure Lecturer</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400">Tailors AI persona</div>
                                </div>
                            </div>
                            <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB 2: COURSE MATERIALS TAB -->
            <div x-show="activeTab === 'materials'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Uploaded Course Materials</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">PDFs uploaded here are parsed and summarized by Gemma AI in the background.</p>
                    </div>

                    <button 
                        wire:click="$set('showMaterialUploadModal', true)" 
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-md hover:bg-indigo-700 shrink-0"
                    >
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Upload PDF Material
                    </button>
                </div>

                @if($course->materials->count() > 0)
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($course->materials as $material)
                            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 space-y-4 shadow-sm relative group">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="size-11 rounded-2xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>

                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold 
                                        @if($material->summary) bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                        @elseif($material->status === 'failed') bg-rose-50 text-rose-700 dark:bg-rose-950 dark:text-rose-400
                                        @elseif(in_array($material->status, ['processing', 'generating_summary', 'generating_pdf'])) bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-400 animate-pulse
                                        @else bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400
                                        @endif
                                    ">
                                        @if(in_array($material->status, ['processing', 'generating_summary', 'generating_pdf']))
                                            <svg class="animate-spin size-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Processing
                                        @elseif($material->summary)
                                            Completed
                                        @elseif($material->status === 'failed')
                                            Failed
                                        @else
                                            Pending
                                        @endif
                                    </span>
                                </div>

                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-1" title="{{ $material->title }}">
                                        {{ $material->title }}
                                    </h4>
                                    <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $material->original_filename }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-50 dark:bg-slate-950 p-3 rounded-xl">
                                    <div><span class="text-slate-400">Pages:</span> <strong class="text-slate-700 dark:text-slate-300">{{ $material->pages ?: 'N/A' }}</strong></div>
                                    <div><span class="text-slate-400">Size:</span> <strong class="text-slate-700 dark:text-slate-300">{{ number_format(($material->file_size ?: 0) / 1024, 1) }} KB</strong></div>
                                    <div><span class="text-slate-400">Uploaded:</span> <strong class="text-slate-700 dark:text-slate-300">{{ $material->created_at->format('M d') }}</strong></div>
                                    <div><span class="text-slate-400">By:</span> <strong class="text-slate-700 dark:text-slate-300">{{ $material->uploader->name ?? 'User' }}</strong></div>
                                </div>

                                @if($material->status === 'failed' && $material->error_message)
                                    <div class="p-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-[11px] text-rose-700 dark:text-rose-300 font-medium">
                                        ⚠️ {{ $material->error_message }}
                                    </div>
                                @endif

                                <!-- AI Summary Actions Section -->
                                @if($material->summary)
                                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <button 
                                                wire:click="viewSummary({{ $material->summary->id }})" 
                                                class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 px-3 py-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 transition"
                                            >
                                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Summary
                                            </button>

                                            @if($material->summary->pdf_path)
                                                <button 
                                                    wire:click="downloadSummary({{ $material->summary->id }})" 
                                                    class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-200 transition"
                                                >
                                                    <svg class="size-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download Summary PDF
                                                </button>
                                            @endif
                                        </div>

                                        <button 
                                            wire:click="regenerateSummary({{ $material->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="regenerateSummary({{ $material->id }})"
                                            class="text-[11px] font-bold text-amber-600 hover:text-amber-700 dark:text-amber-400 transition"
                                        >
                                            Regenerate
                                        </button>
                                    </div>
                                @elseif(in_array($material->status, ['processing', 'generating_summary', 'generating_pdf']))
                                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                                        <button 
                                            disabled 
                                            class="w-full rounded-xl bg-indigo-50 dark:bg-indigo-950/40 px-4 py-2 text-xs font-bold text-indigo-400 dark:text-indigo-500 cursor-not-allowed flex items-center justify-center gap-2"
                                        >
                                            <svg class="animate-spin size-4 text-indigo-500" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Generating Summary...
                                        </button>
                                    </div>
                                @else
                                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                                        <button 
                                            wire:click="generateSummary({{ $material->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="generateSummary({{ $material->id }})"
                                            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-bold px-4 py-2.5 text-xs shadow-md transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <svg wire:loading.remove wire:target="generateSummary({{ $material->id }})" class="size-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                            <svg wire:loading wire:target="generateSummary({{ $material->id }})" class="animate-spin size-4 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            <span wire:loading.remove wire:target="generateSummary({{ $material->id }})">Generate AI Summary</span>
                                            <span wire:loading wire:target="generateSummary({{ $material->id }})">Generating Summary...</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <button 
                                        wire:click="downloadMaterial({{ $material->id }})" 
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"
                                    >
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download PDF
                                    </button>

                                    <button 
                                        wire:click="deleteMaterial({{ $material->id }})" 
                                        wire:confirm="Are you sure you want to delete this course material?" 
                                        class="text-xs font-semibold text-rose-600 hover:text-rose-700 dark:text-rose-400"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-12 text-center">
                        <p class="text-sm font-semibold text-slate-500">No course materials uploaded yet.</p>
                        <button wire:click="$set('showMaterialUploadModal', true)" class="mt-4 rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow">Upload First PDF</button>
                    </div>
                @endif
            </div>

            <!-- TAB 3: PAST QUESTIONS TAB -->
            <div x-show="activeTab === 'past_questions'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Past Examination Papers</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Upload past question PDFs. These are stored and prepared for future AI practice generation.</p>
                    </div>

                    <button 
                        wire:click="$set('showPastQuestionModal', true)" 
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-purple-600 px-5 py-2.5 text-xs font-bold text-white shadow-md hover:bg-purple-700 shrink-0"
                    >
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Upload Past Question PDF
                    </button>
                </div>

                @if($course->pastQuestions->count() > 0)
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($course->pastQuestions as $pq)
                            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 space-y-4 shadow-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="size-11 rounded-2xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300">
                                        {{ $pq->year ?: 'Year N/A' }}
                                    </span>
                                </div>

                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-1">{{ $pq->title }}</h4>
                                    <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $pq->original_filename }}</p>
                                </div>

                                <div class="text-[11px] bg-slate-50 dark:bg-slate-950 p-3 rounded-xl space-y-1">
                                    <div><span class="text-slate-400">Extracted Text:</span> <strong class="text-emerald-600 font-bold">Ready for AI</strong></div>
                                    <div><span class="text-slate-400">Pages:</span> <strong class="text-slate-700 dark:text-slate-300">{{ $pq->pages ?: 'N/A' }}</strong></div>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <span class="text-[11px] text-slate-400">Infrastructure Prepared</span>
                                    <button wire:click="deletePastQuestion({{ $pq->id }})" wire:confirm="Delete past question paper?" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-12 text-center">
                        <p class="text-sm font-semibold text-slate-500">No past question papers uploaded yet.</p>
                        <button wire:click="$set('showPastQuestionModal', true)" class="mt-4 rounded-xl bg-purple-600 px-4 py-2 text-xs font-bold text-white shadow">Upload Past Question PDF</button>
                    </div>
                @endif
            </div>

            <!-- TAB 4: LECTURER TAB -->
            <div x-show="activeTab === 'lecturer'" class="space-y-6">
                <div class="max-w-3xl bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <svg class="size-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Lecturer Profile & AI Context
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            ✨ When configured, Gemma AI automatically injects this lecturer's qualifications, teaching style, and focus areas into academic summary prompts.
                        </p>
                    </div>

                    <form wire:submit.prevent="saveLecturer" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Lecturer Name</label>
                                <input wire:model="lecturer_name" type="text" placeholder="e.g. Prof. Abubakar Sadiq" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                                @error('lecturer_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Profession / Title</label>
                                <input wire:model="lecturer_profession" type="text" placeholder="e.g. Senior Lecturer / Professor" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Highest Qualification</label>
                                <select wire:model="lecturer_highest_qualification" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white">
                                    <option value="Degree">B.Sc / B.Eng (Degree)</option>
                                    <option value="Masters">M.Sc / M.Tech (Masters)</option>
                                    <option value="PhD">Ph.D (Doctorate)</option>
                                    <option value="Professor">Professor</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Discipline / Specialization</label>
                                <input wire:model="lecturer_specialization" type="text" placeholder="e.g. Artificial Intelligence" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Department</label>
                                <input wire:model="lecturer_department" type="text" placeholder="e.g. Computer Science" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Years of Experience</label>
                                <input wire:model="lecturer_years_of_experience" type="number" min="0" max="60" placeholder="15" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Teaching Style</label>
                                <input wire:model="lecturer_teaching_style" type="text" placeholder="e.g. Practical, formula-heavy, exam-focused" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Research Interest</label>
                            <input wire:model="lecturer_research_interest" type="text" placeholder="e.g. Machine Learning, Deep Neural Networks" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Additional Notes</label>
                            <textarea wire:model="lecturer_additional_information" rows="2" placeholder="e.g. Emphasizes mathematical proofs and past question patterns in final exams..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"></textarea>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
                            @if($course->lecturer)
                                <button type="button" wire:click="deleteLecturer" wire:confirm="Remove lecturer profile?" class="rounded-xl px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40">
                                    Delete Profile
                                </button>
                            @else
                                <div></div>
                            @endif

                            <button type="submit" class="rounded-xl bg-indigo-600 px-6 py-2.5 text-xs font-bold text-white shadow-lg hover:bg-indigo-700">
                                Save Lecturer Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 5: AI SUMMARIES TAB -->
            <div x-show="activeTab === 'summaries'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Generated AI Summaries</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">1 Summary is generated per uploaded PDF material. Cleanly structured into 8 academic sections.</p>
                    </div>
                </div>

                @if($course->summaries->count() > 0)
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($course->summaries as $sum)
                            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 space-y-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-extrabold bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                                        </svg>
                                        {{ $sum->ai_model }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $sum->created_at->format('M d, Y') }}</span>
                                </div>

                                <div>
                                    <h4 class="text-base font-extrabold text-slate-900 dark:text-white line-clamp-2">
                                        {{ $sum->title }}
                                    </h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">
                                        Material: {{ $sum->material->original_filename ?? $sum->material->title ?? 'PDF Document' }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-50 dark:bg-slate-950 p-3 rounded-xl">
                                    <div><span class="text-slate-400">Word Count:</span> <strong class="text-slate-700 dark:text-slate-300">{{ str_word_count($sum->plain_text ?: '') }} words</strong></div>
                                    <div><span class="text-slate-400">PDF Path:</span> <strong class="text-emerald-600 font-bold">{{ $sum->pdf_path ? 'Ready' : 'Pending' }}</strong></div>
                                </div>

                                <div class="flex items-center gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <button 
                                        wire:click="viewSummary({{ $sum->id }})" 
                                        class="flex-1 inline-flex justify-center items-center gap-1 rounded-xl bg-indigo-600 px-3 py-2 text-xs font-bold text-white shadow hover:bg-indigo-700"
                                    >
                                        View Summary
                                    </button>

                                    @if($sum->pdf_path)
                                        <a 
                                            href="{{ route('summaries.download', $sum->id) }}" 
                                            target="_blank"
                                            class="inline-flex items-center gap-1 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 px-3 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100"
                                            title="Download DomPDF Document"
                                        >
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            PDF
                                        </a>
                                    @endif

                                    <button 
                                        wire:click="deleteSummary({{ $sum->id }})" 
                                        wire:confirm="Delete this summary?"
                                        class="rounded-xl p-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40"
                                    >
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-12 text-center">
                        <p class="text-sm font-semibold text-slate-500">No summaries generated yet.</p>
                        <p class="text-xs text-slate-400 mt-1">Upload a course material PDF to automatically trigger Gemma AI summary creation.</p>
                    </div>
                @endif
            </div>

            <!-- TAB 6: FUTURE PRACTICE TAB -->
            <div x-show="activeTab === 'future_practice'" class="space-y-6">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-8 dark:border-slate-800 dark:bg-slate-900 text-center max-w-3xl mx-auto space-y-6">
                    <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-purple-50 text-purple-600 dark:bg-purple-950/60 dark:text-purple-400">
                        <svg class="size-8 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white">AI Adaptive Practice & Exam Quiz Engine</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
                            Infrastructure prepared! Once past questions and course materials are uploaded, EduMentor AI will automatically synthesize targeted mock exams, active recall flashcards, and RAG-based practice sessions.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 text-left">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/60 dark:border-slate-800">
                            <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase">Feature 1</div>
                            <div class="text-sm font-bold text-slate-900 dark:text-white mt-1">Mock MCQ Quizzes</div>
                            <p class="text-xs text-slate-400 mt-1">Generated from extracted textbook chunks and past question trends.</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/60 dark:border-slate-800">
                            <div class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase">Feature 2</div>
                            <div class="text-sm font-bold text-slate-900 dark:text-white mt-1">Essay Exam Simulator</div>
                            <p class="text-xs text-slate-400 mt-1">Generates structural exam questions tailored to lecturer style.</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/60 dark:border-slate-800">
                            <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase">Feature 3</div>
                            <div class="text-sm font-bold text-slate-900 dark:text-white mt-1">Multilingual RAG</div>
                            <p class="text-xs text-slate-400 mt-1">Support for English, Hausa, and Yoruba study explanations.</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL 1: MATERIAL UPLOAD MODAL -->
    @if($showMaterialUploadModal || $errors->has('materialTitle') || $errors->has('materialFile'))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Upload Course Material (PDF Only)</h3>
                    <button wire:click="$set('showMaterialUploadModal', false)" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
                </div>

                <form wire:submit="uploadCourseMaterial" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Material Title</label>
                        <input wire:model="materialTitle" type="text" placeholder="e.g. Chapter 1 - Intro to Expert Systems" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        @error('materialTitle') <span class="text-xs text-rose-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">PDF File (Max 20MB)</label>
                        <input 
                            wire:model.live="materialFile" 
                            type="file" 
                            accept=".pdf,application/pdf" 
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-950 dark:file:text-indigo-300 cursor-pointer" 
                        />
                        @error('materialFile') <span class="text-xs text-rose-500 mt-1 block font-semibold">⚠️ {{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showMaterialUploadModal', false)" class="rounded-xl px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="materialFile uploadCourseMaterial"
                            class="rounded-xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center gap-2"
                        >
                            <svg wire:loading wire:target="materialFile uploadCourseMaterial" class="animate-spin size-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="materialFile uploadCourseMaterial">Upload Material</span>
                            <span wire:loading wire:target="materialFile">Uploading PDF...</span>
                            <span wire:loading wire:target="uploadCourseMaterial">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif



    <!-- MODAL 2: PAST QUESTION UPLOAD MODAL -->
    @if($showPastQuestionModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Upload Past Question PDF</h3>
                    <button wire:click="$set('showPastQuestionModal', false)" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form wire:submit="uploadPastQuestion" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Paper Title</label>
                        <input wire:model="pastQuestionTitle" type="text" placeholder="e.g. 2023/2024 First Semester Examination" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        @error('pastQuestionTitle') <span class="text-xs text-rose-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Year</label>
                            <input wire:model="pastQuestionYear" type="number" placeholder="2024" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Semester</label>
                            <input wire:model="pastQuestionSemester" type="text" placeholder="First Semester" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        </div>
                    </div>

                    <div 
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true; progress = 0"
                        x-on:livewire-upload-finish="isUploading = false; progress = 100"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">PDF File</label>
                        <input 
                            wire:model.live="pastQuestionFile" 
                            type="file" 
                            accept="application/pdf" 
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-950 dark:file:text-purple-300 cursor-pointer" 
                        />

                        <!-- Progress Bar -->
                        <div x-show="isUploading" x-cloak class="mt-2 space-y-1">
                            <div class="flex items-center justify-between text-xs text-purple-600 font-semibold">
                                <span>Uploading Past Question PDF to server...</span>
                                <span x-text="progress + '%'"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                                <div class="bg-purple-600 h-2 rounded-full transition-all duration-150" :style="'width: ' + progress + '%'"></div>
                            </div>
                        </div>

                        @if($pastQuestionFile)
                            <div class="mt-2 flex items-center gap-1.5 text-xs text-purple-600 font-semibold">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>File ready for upload!</span>
                            </div>
                        @endif

                        @error('pastQuestionFile') <span class="text-xs text-rose-500 mt-1 block font-semibold">⚠️ {{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showPastQuestionModal', false)" class="rounded-xl px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="pastQuestionFile uploadPastQuestion"
                            class="rounded-xl bg-purple-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center gap-2"
                        >
                            <svg wire:loading wire:target="pastQuestionFile uploadPastQuestion" class="animate-spin size-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="pastQuestionFile uploadPastQuestion">Save Past Question</span>
                            <span wire:loading wire:target="pastQuestionFile">Uploading PDF...</span>
                            <span wire:loading wire:target="uploadPastQuestion">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL 3: VIEW SUMMARY MODAL -->
    @if($showSummaryModal && $selectedSummary)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-md">
            <div class="w-full max-w-4xl max-h-[90vh] flex flex-col rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-extrabold bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                            {{ $selectedSummary->ai_model }} &bull; {{ $selectedSummary->created_at->format('M d, Y') }}
                        </span>
                        <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mt-1">{{ $selectedSummary->title }}</h3>
                    </div>

                    <div class="flex items-center gap-3">
                        @if($selectedSummary->pdf_path)
                            <a 
                                href="{{ route('summaries.download', $selectedSummary->id) }}" 
                                target="_blank"
                                class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow hover:bg-indigo-700"
                            >
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download DomPDF
                            </a>
                        @endif

                        <button wire:click="$set('showSummaryModal', false)" class="text-slate-400 hover:text-slate-600 text-xl font-bold px-2">&times;</button>
                    </div>
                </div>

                <!-- Scrollable Content View -->
                <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-6 prose dark:prose-invert max-w-none">
                    {!! $selectedSummary->html_content !!}
                </div>

                <!-- Footer -->
                <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex items-center justify-between text-xs text-slate-400">
                    <span>Generated by Gemma AI &bull; EduMentor AI Engine</span>
                    <button wire:click="$set('showSummaryModal', false)" class="rounded-xl px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold">Close View</button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL 4: EDIT COURSE DETAILS MODAL -->
    @if($showEditCourseModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Edit Course Info</h3>
                    <button wire:click="$set('showEditCourseModal', false)" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form wire:submit.prevent="updateCourseInfo" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Course Code</label>
                        <input wire:model="course_code" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Course Title</label>
                        <input wire:model="course_title" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Course Unit</label>
                            <input wire:model="course_unit" type="number" min="1" max="12" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Semester</label>
                            <select wire:model="semester" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white">
                                <option value="First Semester">First Semester</option>
                                <option value="Second Semester">Second Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Description</label>
                        <textarea wire:model="description" rows="3" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Status</label>
                        <select wire:model="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white">
                            <option value="active">Active</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="deleteCourse" wire:confirm="Are you sure you want to delete this course entirely?" class="rounded-xl px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50">Delete Course</button>
                        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg hover:bg-indigo-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
