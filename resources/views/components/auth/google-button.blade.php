@props([
    'loadingTarget',
    'defaultText' => 'Continue with Google',
])

<button
    type="button"
    {{ $attributes->merge(['class' => 'group flex w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-4 text-base font-semibold text-slate-800 shadow-lg shadow-slate-950/5 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-indigo-500/20 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 disabled:cursor-wait disabled:opacity-75 dark:border-white/10 dark:bg-white/10 dark:text-white']) }}
    wire:loading.attr="disabled"
    wire:target="{{ $loadingTarget }}"
>
    <span wire:loading.remove wire:target="{{ $loadingTarget }}" class="flex items-center gap-3">
        <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09Z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84A10.99 10.99 0 0 0 12 23Z"/>
            <path fill="#FBBC05" d="M5.84 14.1a6.59 6.59 0 0 1 0-4.2V7.06H2.18a10.99 10.99 0 0 0 0 9.88l3.66-2.84Z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15A10.53 10.53 0 0 0 12 1 10.99 10.99 0 0 0 2.18 7.06L5.84 9.9C6.71 7.31 9.14 5.38 12 5.38Z"/>
        </svg>
        {{ $defaultText }}
    </span>

    <span wire:loading.flex wire:target="{{ $loadingTarget }}" class="items-center gap-3">
        <x-auth.loading-spinner />
        Redirecting to Google...
    </span>
</button>
