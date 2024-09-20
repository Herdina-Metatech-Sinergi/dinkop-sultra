{{-- <button type="button" x-on:click="tab = 'tab-a'"
class="filament-forms-tabs-component-button flex items-center gap-2 shrink-0 p-3 text-sm font-medium filament-forms-tabs-component-button-active bg-white text-primary-600 dark:bg-gray-800"
x-bind:class="{
    'text-gray-500 hover:text-gray-800 focus:text-primary-600  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:text-primary-600 ': tab !==
        'tab-a',
    'filament-forms-tabs-component-button-active bg-white text-primary-600  dark:bg-gray-800 ': tab ===
        'tab-a',
}"
aria-selected="true" tabindex="0">
<span>Tab A</span>
</button> --}}
@props([
    'tab' => 'tab',
    'id' => '',
])

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' =>
            'filament-forms-tabs-component-button flex items-center gap-2 shrink-0 p-3 text-sm font-medium filament-forms-tabs-component-button-active bg-white text-primary-600 dark:bg-gray-800',
    ]) }}
    x-on:click="{{ $tab }} = '{{ $id }}'"
    x-bind:class="{
        'text-gray-500 hover:text-gray-800 focus:text-primary-600  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:text-primary-600 ': {{ $tab }} !==
            '{{ $id }}',
        'filament-forms-tabs-component-button-active bg-white text-primary-600  dark:bg-gray-800 ': {{ $tab }} ===
            '{{ $id }}',
    }"
    aria-selected="true" tabindex="0">
    {{ $slot }}
</button>
