{{-- <div x-data="{
    tab: 'tab-a',
}"
    class="filament-forms-tabs-component rounded-xl shadow-sm border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-700">
    <div aria-label="Details" role="tablist"
        class="filament-forms-tabs-component-header rounded-t-xl flex overflow-y-auto bg-gray-100 dark:bg-gray-700">
        <button type="button" x-on:click="tab = 'tab-a'"
            class="filament-forms-tabs-component-button flex items-center gap-2 shrink-0 p-3 text-sm font-medium filament-forms-tabs-component-button-active bg-white text-primary-600 dark:bg-gray-800"
            x-bind:class="{
                'text-gray-500 hover:text-gray-800 focus:text-primary-600  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:text-primary-600 ': tab !==
                    'tab-a',
                'filament-forms-tabs-component-button-active bg-white text-primary-600  dark:bg-gray-800 ': tab ===
                    'tab-a',
            }"
            aria-selected="true" tabindex="0">
            <span>Tab A</span>
        </button>
        <button type="button" x-on:click="tab = 'tab-b'"
            class="filament-forms-tabs-component-button flex items-center gap-2 shrink-0 p-3 text-sm font-medium filament-forms-tabs-component-button-active bg-white text-primary-600 dark:bg-gray-800"
            x-bind:class="{
                'text-gray-500 hover:text-gray-800 focus:text-primary-600  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:text-primary-600 ': tab !==
                    'tab-b',
                'filament-forms-tabs-component-button-active bg-white text-primary-600  dark:bg-gray-800 ': tab ===
                    'tab-b',
            }"
            aria-selected="true" tabindex="0">
            <span>Tab B</span>
        </button>
    </div>

    <div aria-labelledby="tab-a" id="tab-a" role="tabpanel" tabindex="0"
        x-bind:class="{ 'invisible h-0 p-0 overflow-y-hidden': tab !== 'tab-a', 'p-6': tab === 'tab-a' }"
        class="filament-forms-tabs-component-tab outline-none p-6">
        <div class="grid grid-cols-1   lg:grid-cols-2   filament-forms-component-container gap-6">
            Isi tab A
        </div>
    </div>
    <div aria-labelledby="tab-b" id="tab-b" role="tabpanel" tabindex="0"
        x-bind:class="{ 'invisible h-0 p-0 overflow-y-hidden': tab !== 'tab-b', 'p-6': tab === 'tab-b' }"
        class="filament-forms-tabs-component-tab outline-none p-6">
        <div class="grid grid-cols-1   lg:grid-cols-2   filament-forms-component-container gap-6">
            Isi tab B
        </div>
    </div>
</div> --}}
@props([
    'tab' => 'tab',
    'customClass' => null,
    'defaultTab' => '',
])

<div {{ $attributes->merge([
    'class' =>
        $customClass .
        ' filament-forms-tabs-component rounded-xl shadow-sm border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-700',
]) }}
    x-data="{
        {{ $tab }}: '{{ $defaultTab }}',
    }">
    <div role="tablist"
        class="filament-forms-tabs-component-header rounded-t-xl flex overflow-y-auto bg-gray-100 dark:bg-gray-700">
        {{ $navButton }}
    </div>

    {{ $tabContainer }}
</div>
