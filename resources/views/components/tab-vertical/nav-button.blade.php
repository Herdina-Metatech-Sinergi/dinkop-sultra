@props([
    'tab' => 'tab',
    'id' => '',
])

<div {{ $attributes->merge([
    'class' => 'cursor-pointer tab-link rounded-md p-2 mb-2 hover:bg-gray-300 transition duration-300',
]) }}
    x-on:click="{{ $tab }} = '{{ $id }}'"
    :class="{ 'bg-blue-500 text-white': {{ $tab }} == '{{ $id }}' }">
    {{ $slot }}
</div>
