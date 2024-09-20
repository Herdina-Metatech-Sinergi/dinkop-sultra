@props([
    'customClass' => '',
    'customStyle' => '',
])

<tr class="border-b dark:border-neutral-500 {{ $customClass }}" style="{{ $customStyle }}">
    {{ $slot }}
</tr>
