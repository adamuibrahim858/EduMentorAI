<div class="min-h-screen bg-[linear-gradient(135deg,#f8fafc_0%,#eef2ff_45%,#eff6ff_100%)] dark:bg-[linear-gradient(135deg,#020617_0%,#111827_55%,#172554_100%)]">
    <nav class="border-b border-white/70 bg-white/75 backdrop-blur-xl dark:border-white/10 dark:bg-slate-950/60">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-6 py-5">
            <x-auth.logo />

            <div class="flex min-w-0 items-center gap-4">
                <img
                    src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff' }}"
                    alt="{{ $user->name }} avatar"
                    class="size-11 rounded-2xl object-cover ring-2 ring-white dark:ring-white/10"
                >
                <div class="hidden min-w-0 text-right sm:block">
                    <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $user->name }}</p>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-2xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/10 transition hover:bg-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 dark:bg-white dark:text-slate-950 dark:hover:bg-indigo-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-6 py-10">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-8 shadow-2xl shadow-indigo-950/10 backdrop-blur-xl dark:border-white/10 dark:bg-white/10 sm:p-10">
            <div class="grid gap-8 lg:grid-cols-[auto_1fr] lg:items-center">
                <img
                    src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff' }}"
                    alt="{{ $user->name }} profile picture"
                    class="size-28 rounded-[2rem] object-cover shadow-xl shadow-indigo-950/10"
                >
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-300">Dashboard</p>
                    <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 dark:text-white">Welcome back, {{ $user->name }}</h1>
                    <p class="mt-3 text-base text-slate-600 dark:text-slate-300">You are successfully authenticated.</p>
                </div>
            </div>
        </section>

        <section class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @php
                $profileFields = [
                    'Profile Picture' => $user->avatar ?: 'Generated avatar',
                    'Name' => $user->name,
                    'Email' => $user->email,
                    'Provider' => ucfirst($user->provider ?? 'google'),
                    'Last Login' => $user->last_login_at?->format('M j, Y g:i A') ?? 'Not recorded',
                    'Member Since' => $user->created_at?->format('M j, Y') ?? 'Not recorded',
                    'Account Status' => ucfirst($user->status ?? 'active'),
                    'Google ID' => $user->google_id ?? $user->provider_id ?? 'Not recorded',
                ];
            @endphp

            @foreach ($profileFields as $label => $value)
                <article class="rounded-3xl border border-white/70 bg-white/80 p-6 shadow-xl shadow-slate-950/5 backdrop-blur-xl dark:border-white/10 dark:bg-white/10">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">{{ $label }}</p>
                    <p class="mt-3 break-words text-base font-semibold text-slate-950 dark:text-white">{{ $value }}</p>
                </article>
            @endforeach
        </section>
    </main>
</div>
