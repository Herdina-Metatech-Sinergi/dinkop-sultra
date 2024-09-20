@props([
    'color' => 'primary',
])

<div
    {{ $attributes->merge([
        'type' => 'button',
        'class' => "min-h-6 inline-flex items-center justify-center space-x-1 whitespace-nowrap rounded-xl px-2 py-0.5 text-sm font-medium tracking-tight rtl:space-x-reverse text-{$color}-700 bg-{$color}-500/10 dark:text-{$color}-500",
    ]) }}>
    <span class="">
        {{ $slot }}
    </span>
</div>
