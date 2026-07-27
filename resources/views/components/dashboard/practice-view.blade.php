<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">AI Practice & Quizzes</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Test your mastery with AI generated adaptive questions and instant feedback.</p>
        </div>
        <button 
            type="button" 
            @click="alert('Starting new AI practice quiz (UI Preview)')"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-500 active:translate-y-0 shrink-0"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Generate Quiz
        </button>
    </div>

    <!-- Practice Sessions Modern Table -->
    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-200/80 bg-slate-50/80 text-slate-500 uppercase tracking-wider font-bold dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-400">
                    <tr>
                        <th class="py-4 px-6">Practice Topic</th>
                        <th class="py-4 px-6">Course / Module</th>
                        <th class="py-4 px-6">Progress</th>
                        <th class="py-4 px-6">Score</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 font-medium">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex size-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-300 font-bold">
                                    ✓
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white">Neural Networks & Gradient Descent</p>
                                    <p class="text-[10px] text-slate-400">20 Questions • 15 mins</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-600 dark:text-slate-300">Artificial Intelligence</td>
                        <td class="py-4 px-6 w-36">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: 100%;"></div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400">100%</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400">95%</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                <span class="size-1.5 rounded-full bg-emerald-500"></span> Passed
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 transition">
                                Retake Quiz
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex size-9 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-950 dark:text-amber-300 font-bold">
                                    ⏳
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white">Eigenvalues & Matrix Transformations</p>
                                    <p class="text-[10px] text-slate-400">15 Questions • In Progress</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-600 dark:text-slate-300">Linear Algebra</td>
                        <td class="py-4 px-6 w-36">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                    <div class="h-full bg-amber-500 rounded-full" style="width: 60%;"></div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400">60%</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-extrabold text-amber-600 dark:text-amber-400">88%</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                <span class="size-1.5 rounded-full bg-amber-500 animate-ping"></span> In Progress
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="rounded-xl bg-indigo-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow hover:bg-indigo-500 transition">
                                Resume Practice →
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex size-9 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-300 font-bold">
                                    ⚡
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white">Wave Functions & Probability Density</p>
                                    <p class="text-[10px] text-slate-400">25 Questions • 20 mins</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-600 dark:text-slate-300">Quantum Mechanics</td>
                        <td class="py-4 px-6 w-36">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full" style="width: 100%;"></div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400">100%</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400">92%</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 rounded-full bg-indigo-100 px-2.5 py-1 text-[10px] font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                <span class="size-1.5 rounded-full bg-indigo-500"></span> Completed
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 transition">
                                Review Answers
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
