@props([
    'tab' => 'tab',
    'id' => '',
])

<div {{ $attributes->merge([
    'class' => 'p-4',
]) }}
    x-bind:class="{
        'invisible h-0 p-0 overflow-y-hidden': {{ $tab }} !=
            '{{ $id }}',
        'p-4': {{ $tab }} == '{{ $id }}'
    }">
    {{ $slot }}
</div>
