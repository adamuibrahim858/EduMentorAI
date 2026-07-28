<x-layouts.dashboard title="Profile">
    <div 
        x-data="{ avatarSrc: '{{ $user->avatar ? (str_starts_with($user->avatar, "http") ? $user->avatar : asset("storage/" . $user->avatar)) : "" }}' }"
        class="space-y-6"
    >
        {{-- Breadcrumb Navigation --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
            <svg class="size-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-slate-900 dark:text-white font-bold">Profile</span>
        </nav>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/50 dark:border-emerald-800 p-4 text-sm font-semibold text-emerald-800 dark:text-emerald-200 flex items-center gap-2 shadow-sm">
                <svg class="size-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-2xl bg-rose-50 border border-rose-200 dark:bg-rose-950/50 dark:border-rose-800 p-4 text-sm font-semibold text-rose-800 dark:text-rose-200 flex items-center gap-2 shadow-sm">
                <svg class="size-5 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- COVER BANNER --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-900 via-slate-900 to-purple-950 p-6 sm:p-10 text-white shadow-xl border border-slate-800">
            <div class="absolute -right-20 -top-20 size-80 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 size-80 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                    {{-- Avatar --}}
                    <div class="relative size-28 shrink-0">
                        <div class="size-full rounded-3xl p-1 bg-gradient-to-tr from-indigo-500 via-purple-500 to-blue-400 shadow-2xl">
                            <template x-if="avatarSrc">
                                <img :src="avatarSrc" alt="{{ $user->name }}" class="size-full rounded-[1.3rem] object-cover">
                            </template>
                            <template x-if="!avatarSrc">
                                <img src="{{ 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff&size=200' }}" alt="{{ $user->name }}" class="size-full rounded-[1.3rem] object-cover">
                            </template>
                        </div>
                        @if($user->avatar)
                            <button wire:click="removeAvatar" wire:confirm="Remove your avatar?" class="absolute -top-2 -right-2 size-6 rounded-full bg-rose-500 text-white text-xs flex items-center justify-center shadow hover:bg-rose-600">✕</button>
                        @endif
                    </div>

                    <div class="space-y-1">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $user->name }}</h1>
                        <p class="text-sm text-slate-300">{{ $user->email }}</p>
                        <p class="text-xs text-indigo-300 font-medium">EduMentor AI Student · Joined {{ $user->created_at?->format('M Y') }}</p>
                    </div>
                </div>

                <a href="#edit-profile" class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow hover:bg-slate-100 transition">
                    <svg class="size-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit Profile
                </a>
            </div>
        </div>

        {{-- EDIT PROFILE FORM --}}
        <div id="edit-profile" class="grid gap-8 lg:grid-cols-3">

            {{-- LEFT: Avatar Upload --}}
            <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm space-y-5 h-fit">
                <h2 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wide">Avatar</h2>

                <div class="flex flex-col items-center gap-4">
                    <div class="size-24 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-indigo-300 dark:border-indigo-700 flex items-center justify-center">
                        <template x-if="avatarSrc">
                            <img :src="avatarSrc" class="size-full object-cover">
                        </template>
                        <template x-if="!avatarSrc">
                            <svg class="size-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </template>
                    </div>

                    <label class="cursor-pointer w-full">
                        <span class="block w-full text-center rounded-xl bg-indigo-50 dark:bg-indigo-950/60 px-4 py-2.5 text-xs font-bold text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 transition">
                            Choose Image
                        </span>
                        <input
                            wire:model.live="avatar"
                            type="file"
                            accept="image/jpg,image/jpeg,image/png,image/webp"
                            class="sr-only"
                            x-on:change="
                                const file = $event.target.files[0];
                                if (file) avatarSrc = URL.createObjectURL(file);
                            "
                        >
                    </label>

                    <p class="text-[11px] text-slate-400 text-center">JPG, PNG or WebP · Max 2MB</p>

                    @error('avatar') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- RIGHT: Forms --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Personal Information --}}
                <form wire:submit="updateProfile" class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm space-y-6">
                    <h2 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wide border-b border-slate-100 dark:border-slate-800 pb-4">Personal Information</h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Full Name</label>
                            <input wire:model="name" type="text" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Email Address</label>
                            <input wire:model="email" type="email" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Phone Number</label>
                            <input wire:model="phone" type="tel" placeholder="+234 800 000 0000" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <h3 class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wide pt-2 border-t border-slate-100 dark:border-slate-800">Academic Information</h3>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Institution</label>
                            <input wire:model="institution" type="text" placeholder="University of Lagos" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('institution') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Faculty</label>
                            <input wire:model="faculty" type="text" placeholder="Faculty of Engineering" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('faculty') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Department</label>
                            <input wire:model="department" type="text" placeholder="Computer Science" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('department') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Level</label>
                            <select wire:model="level" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                <option value="">Select Level</option>
                                @foreach(['100', '200', '300', '400', '500', '600', 'Postgraduate', 'Masters', 'PhD'] as $l)
                                    <option value="{{ $l }}" @selected($level === $l)>{{ $l }} Level</option>
                                @endforeach
                            </select>
                            @error('level') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Semester</label>
                            <select wire:model="semester" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                <option value="">Select Semester</option>
                                <option value="First" @selected($semester === 'First')>First Semester</option>
                                <option value="Second" @selected($semester === 'Second')>Second Semester</option>
                            </select>
                            @error('semester') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Biography</label>
                        <textarea wire:model="bio" rows="3" placeholder="Tell us a little about yourself..." class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white resize-none"></textarea>
                        <p class="mt-1 text-[11px] text-slate-400">{{ strlen($bio) }}/1000 characters</p>
                        @error('bio') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end border-t border-slate-100 dark:border-slate-800 pt-4">
                        <button type="submit" wire:loading.attr="disabled" wire:target="updateProfile" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition disabled:opacity-60">
                            <svg wire:loading wire:target="updateProfile" class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                            <span wire:loading wire:target="updateProfile">Saving...</span>
                        </button>
                    </div>
                </form>

                {{-- Account Information --}}
                <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm space-y-4">
                    <h2 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wide border-b border-slate-100 dark:border-slate-800 pb-4">Account Information</h2>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-950 p-4 border border-slate-100 dark:border-slate-800">
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Provider</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white capitalize">
                                @if($user->provider === 'google')
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="size-4 text-rose-500" viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                        Google
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="size-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        Email
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-950 p-4 border border-slate-100 dark:border-slate-800">
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Member Since</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->created_at?->format('M j, Y') }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-950 p-4 border border-slate-100 dark:border-slate-800">
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Last Login</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->last_login_at?->format('M j, Y g:i A') ?? 'Now' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-950 p-4 border border-slate-100 dark:border-slate-800">
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Account Status</p>
                            <p class="text-sm font-bold capitalize {{ $user->status === 'active' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $user->status }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-950 p-4 border border-slate-100 dark:border-slate-800">
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Email Verified</p>
                            <p class="text-sm font-bold {{ $user->email_verified_at ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Security / Password Change --}}
                @if($showPasswordSection)
                    <form wire:submit="changePassword" class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm space-y-6">
                        <h2 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wide border-b border-slate-100 dark:border-slate-800 pb-4">Security — Change Password</h2>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Current Password</label>
                                <input wire:model="currentPassword" type="password" autocomplete="current-password" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                @error('currentPassword') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">New Password</label>
                                <input wire:model="newPassword" type="password" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                @error('newPassword') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Confirm New Password</label>
                                <input wire:model="confirmPassword" type="password" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                @error('confirmPassword') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-slate-100 dark:border-slate-800 pt-4">
                            <button type="submit" wire:loading.attr="disabled" wire:target="changePassword" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 hover:from-slate-700 hover:to-slate-800 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition disabled:opacity-60">
                                <svg wire:loading wire:target="changePassword" class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                <span wire:loading.remove wire:target="changePassword">Update Password</span>
                                <span wire:loading wire:target="changePassword">Updating...</span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                        <h2 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wide border-b border-slate-100 dark:border-slate-800 pb-4 mb-4">Security</h2>
                        <div class="flex items-center gap-3 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900 p-4">
                            <svg class="size-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm text-blue-800 dark:text-blue-200 font-medium">Your account uses Google Sign-In. Password management is handled by Google.</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.dashboard>
