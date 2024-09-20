{{-- <div aria-labelledby="tab-a" id="tab-a" role="tabpanel" tabindex="0"
    x-bind:class="{ 'invisible h-0 p-0 overflow-y-hidden': tab !== 'tab-a', 'p-6': tab === 'tab-a' }"
    class="filament-forms-tabs-component-tab outline-none p-6">
    <div class="grid grid-cols-1   lg:grid-cols-2   filament-forms-component-container gap-6">
        Isi tab A
    </div>
</div> --}}
@props([
    'tab' => 'tab',
    'id' => '',
    'customClass' => '',
])

<div {{ $attributes->merge([
    'class' => 'filament-forms-tabs-component-tab outline-none p-6 ' . $customClass,
]) }}
    id="{{ $id }}" role="tabpanel" tabindex="0"
    x-bind:class="{
        'invisible h-0 p-0 overflow-y-hidden': {{ $tab }} !==
            '{{ $id }}',
        'p-6': {{ $tab }} === '{{ $id }}'
    }"
    class="">
    <div class="grid grid-cols-1 filament-forms-component-container gap-6">
        {{ $slot }}
    </div>
</div>
