@props([
    'tab' => 'tab',
    'customClass' => null,
    'defaultTab' => '',
])

<div {{ $attributes->merge([
    'class' => $customClass . ' flex',
]) }} x-data="{
    {{ $tab }}: '{{ $defaultTab }}',
}">
    <div class="flex-none">
        <div class="flex flex-col">
            {{ $navButton }}
        </div>
    </div>
    <div class="ml-2 flex-1 border-l border-gray-300">
        {{ $tabContainer }}
    </div>
</div>
