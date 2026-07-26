<div class="relative grid min-h-screen place-items-center px-6 py-10 sm:px-8">
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,#f8fafc_0%,#eef2ff_38%,#eff6ff_70%,#faf5ff_100%)] dark:bg-[linear-gradient(135deg,#020617_0%,#111827_45%,#172554_100%)]"></div>

    <x-auth.card class="text-center">
        <div class="mx-auto grid size-16 place-items-center rounded-3xl bg-rose-100 text-2xl font-black text-rose-600 dark:bg-rose-500/15 dark:text-rose-200">!</div>

        <div class="mt-8 space-y-3">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Authentication failed</h1>
            <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $message }}</p>
        </div>

        <a
            href="{{ route('login') }}"
            wire:navigate
            class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25"
        >
            Retry Login
        </a>
    </x-auth.card>
</div>
