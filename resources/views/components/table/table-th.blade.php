@props([
    'customClass' => '',
])

<th class="filament-tables-header-cell p-0 filament-table-header-cell-nama-obat">
    <button type="button"
        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-bold text-sm text-black dark:text-gray-300 cursor-default  {{ $customClass }}">
        {{ $slot }}
    </button>
</th>
