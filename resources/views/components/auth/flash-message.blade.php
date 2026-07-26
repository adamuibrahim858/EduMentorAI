@props(['message' => null, 'type' => 'error'])

@if ($message)
    <div {{ $attributes->merge(['class' => 'rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 dark:border-rose-400/30 dark:bg-rose-500/10 dark:text-rose-100']) }} role="alert">
        {{ $message }}
    </div>
@endif
