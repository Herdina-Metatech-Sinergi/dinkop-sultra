@props([
    'customClass' => '',
    'customStyle' => '',
])

<td colspan="999" class="border-collapse border">
    <div class="px-1 py-1">
        <div class="text-center space-x-1 rtl:space-x-reverse">
            <span class="text-sm {{ $customClass }}" style="{{ $customStyle }}">
                {{ $slot }}
            </span>
        </div>
    </div>
</td>
