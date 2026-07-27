<div class="space-y-8" x-data="{ searchQuery: '', filterCategory: 'all', showEmptyState: false }">
    
    <!-- Page Header & Main Actions -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Your AI Enrolled Courses</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Manage syllabus materials, AI flashcards, and smart chapter summaries.</p>
        </div>
        <button 
            type="button"
            @click="showEmptyState = !showEmptyState"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0 shrink-0"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Course
        </button>
    </div>

    <!-- Search & Filters Toolbar -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-3xl border border-slate-200/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="relative flex-1">
            <svg class="size-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input 
                x-model="searchQuery"
                type="text" 
                placeholder="Search course titles or subjects..." 
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-800/60 dark:text-white"
            >
        </div>

        <div class="flex items-center gap-2">
            <select 
                x-model="filterCategory"
                class="rounded-2xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-xs font-semibold text-slate-700 focus:border-indigo-500 focus:outline-none dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-300"
            >
                <option value="all">All Categories</option>
                <option value="cs">Computer Science</option>
                <option value="physics">Physics & Math</option>
                <option value="ai">Artificial Intelligence</option>
            </select>
        </div>
    </div>

    <!-- Empty State View (Toggleable or standard) -->
    <div x-show="showEmptyState" x-transition class="rounded-3xl border border-dashed border-slate-300 bg-slate-50/50 p-12 text-center dark:border-slate-800 dark:bg-slate-900/40">
        <div class="mx-auto flex size-20 items-center justify-center rounded-3xl bg-indigo-100 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 shadow-inner">
            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">No courses added yet</h3>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Upload a syllabus, lecture notes, or PDF document to let AI construct your customized study course.</p>
        <button 
            type="button" 
            @click="showEmptyState = false"
            class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-md hover:bg-indigo-500 transition"
        >
            + Create First AI Course
        </button>
    </div>

    <!-- Active Courses Grid -->
    <div x-show="!showEmptyState" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        
        <!-- Course Card 1 -->
        <div class="group relative flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10 dark:border-slate-800 dark:bg-slate-900">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-[10px] font-extrabold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">CS-402</span>
                    <span class="flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                        <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 transition">Artificial Intelligence & Deep Learning</h3>
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2">Neural networks, backpropagation algorithms, optimization methods, and transformer architecture.</p>
            </div>

            <div class="mt-6 space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1.5">
                        <span class="text-slate-500 dark:text-slate-400">Progress</span>
                        <span class="text-indigo-600 dark:text-indigo-400">78%</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-600" style="width: 78%;"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">14 AI Summaries</span>
                    <button class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-800 hover:bg-indigo-600 hover:text-white dark:bg-slate-800 dark:text-slate-200 transition">
                        Open Course →
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 2 -->
        <div class="group relative flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/10 dark:border-slate-800 dark:bg-slate-900">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-[10px] font-extrabold text-blue-700 dark:bg-blue-950 dark:text-blue-300">MATH-301</span>
                    <span class="flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                        <span class="size-2 rounded-full bg-emerald-500"></span>
                        Active
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition">Linear Algebra & Vector Calculus</h3>
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2">Eigenvalues, eigenvectors, singular value decomposition, and multidimensional calculus.</p>
            </div>

            <div class="mt-6 space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1.5">
                        <span class="text-slate-500 dark:text-slate-400">Progress</span>
                        <span class="text-blue-600 dark:text-blue-400">92%</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600" style="width: 92%;"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">22 Practice Sets</span>
                    <button class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-800 hover:bg-blue-600 hover:text-white dark:bg-slate-800 dark:text-slate-200 transition">
                        Open Course →
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 3 -->
        <div class="group relative flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-500/10 dark:border-slate-800 dark:bg-slate-900">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="rounded-full bg-purple-100 px-3 py-1 text-[10px] font-extrabold text-purple-700 dark:bg-purple-950 dark:text-purple-300">PHYS-202</span>
                    <span class="flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                        <span class="size-2 rounded-full bg-emerald-500"></span>
                        Active
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-purple-600 transition">Quantum Mechanics & Thermodynamics</h3>
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2">Schrödinger equation, wave functions, entropy, state variables, and statistical physics.</p>
            </div>

            <div class="mt-6 space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1.5">
                        <span class="text-slate-500 dark:text-slate-400">Progress</span>
                        <span class="text-purple-600 dark:text-purple-400">65%</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-purple-500 to-pink-600" style="width: 65%;"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">8 Flashcard Decks</span>
                    <button class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-800 hover:bg-purple-600 hover:text-white dark:bg-slate-800 dark:text-slate-200 transition">
                        Open Course →
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
