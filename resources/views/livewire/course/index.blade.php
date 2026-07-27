<div 
    x-data="{ 
        currentTab: 'courses', 
        sidebarCollapsed: false, 
        mobileSidebarOpen: false,
        darkMode: (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
    }" 
    class="min-h-screen bg-[#F8FAFC] text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100"
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
            
            <!-- Header Banner -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 mb-2">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Course Management
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        My Enrolled Courses
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Manage your academic courses, upload study materials, and access AI-generated summaries.
                    </p>
                </div>

                <button 
                    wire:click="openCreateModal" 
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700 hover:-translate-y-0.5 shrink-0"
                >
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Course
                </button>
            </div>

            <!-- Flash Alert -->
            @if (session()->has('message'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/40 dark:border-emerald-800 p-4 text-sm font-semibold text-emerald-800 dark:text-emerald-300 flex items-center justify-between">
                    <span>✨ {{ session('message') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400">&times;</button>
                </div>
            @endif



            <!-- Course Cards Grid -->
            @if($courses->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($courses as $course)
                        <div class="group relative flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-900">
                            <!-- Top Header Badges -->
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-4">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-indigo-50 text-indigo-700 dark:bg-indigo-950/80 dark:text-indigo-300 uppercase tracking-wider border border-indigo-200/60 dark:border-indigo-800/60 shadow-xs">
                                        {{ $course->course_code }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $course->status === 'active' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                                        <span class="size-1.5 rounded-full {{ $course->status === 'active' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-1">
                                    <a href="{{ route('courses.show', $course->id) }}" class="focus:outline-none focus:underline">
                                        {{ $course->course_title }}
                                    </a>
                                </h3>

                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed min-h-[2.25rem]">
                                    {{ $course->description ?: 'No course description provided yet.' }}
                                </p>
                            </div>

                            <!-- Details & Stats Section -->
                            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 space-y-4">
                                <!-- Units & Semester Meta -->
                                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="size-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        Unit: <strong class="text-slate-900 dark:text-slate-100 font-bold">{{ $course->course_unit }} Credits</strong>
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="size-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <strong class="text-slate-900 dark:text-slate-100 font-bold">{{ $course->semester }}</strong>
                                    </span>
                                </div>

                                <!-- 3-Column Horizontal Stats Bar -->
                                <div class="flex items-center justify-between gap-2 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-100 dark:border-slate-800/80">
                                    <div class="flex-1 text-center">
                                        <div class="text-base font-black text-slate-900 dark:text-white leading-none">{{ $course->materials_count }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide mt-1">PDFs</div>
                                    </div>
                                    <div class="h-6 w-px bg-slate-200 dark:bg-slate-800"></div>
                                    <div class="flex-1 text-center">
                                        <div class="text-base font-black text-indigo-600 dark:text-indigo-400 leading-none">{{ $course->summaries_count }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide mt-1">Summaries</div>
                                    </div>
                                    <div class="h-6 w-px bg-slate-200 dark:bg-slate-800"></div>
                                    <div class="flex-1 text-center">
                                        <div class="text-base font-black text-purple-600 dark:text-purple-400 leading-none">{{ $course->past_questions_count }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide mt-1">Past Qs</div>
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="flex items-center justify-between gap-2 pt-1">
                                    <a 
                                        href="{{ route('courses.show', $course->id) }}" 
                                        class="flex-1 inline-flex justify-center items-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white px-4 py-2.5 text-xs font-bold shadow-md shadow-indigo-600/20 transition-all duration-200 group/btn"
                                    >
                                        <span>Open Course</span>
                                        <svg class="size-4 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>

                                    <button 
                                        wire:click="openEditModal({{ $course->id }})" 
                                        class="rounded-xl border border-slate-200 dark:border-slate-800 p-2.5 text-slate-500 hover:bg-slate-100 hover:text-indigo-600 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-indigo-400 transition-all"
                                        title="Edit Course Details"
                                    >
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-12 text-center">
                    <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 mb-4">
                        <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No courses created yet</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1 mb-6">
                        Get started by creating your first course to upload materials and generate AI study summaries.
                    </p>
                    <button 
                        wire:click="openCreateModal" 
                        class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-xs font-bold text-white shadow-lg transition hover:bg-indigo-700"
                    >
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Your First Course
                    </button>
                </div>
            @endif

        </main>
    </div>

    <!-- Create / Edit Course Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">
                        {{ $editingCourseId ? 'Edit Course Details' : 'Create New Course' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">&times;</button>
                </div>

                <form wire:submit.prevent="saveCourse" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Course Code</label>
                        <input wire:model="course_code" type="text" placeholder="e.g. CSC 401" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        @error('course_code') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Course Title</label>
                        <input wire:model="course_title" type="text" placeholder="e.g. Artificial Intelligence & Expert Systems" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                        @error('course_title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Course Units</label>
                            <input wire:model="course_unit" type="number" min="1" max="12" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white" />
                            @error('course_unit') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Semester</label>
                            <select wire:model="semester" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white">
                                <option value="First Semester">First Semester</option>
                                <option value="Second Semester">Second Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                            @error('semester') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Description (Optional)</label>
                        <textarea wire:model="description" rows="3" placeholder="Brief outline of course scope and syllabus..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Status</label>
                        <select wire:model="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white">
                            <option value="active">Active</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showModal', false)" class="rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">
                            Cancel
                        </button>
                        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg hover:bg-indigo-700">
                            {{ $editingCourseId ? 'Save Changes' : 'Create Course' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
