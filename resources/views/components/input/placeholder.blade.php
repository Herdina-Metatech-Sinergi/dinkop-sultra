@props([
    'customClass' => '',
    'title' => '',
    'slot' => '',
    'colspanClass' => 'col-span-1',
])

<div {{ $attributes->merge([
    'class' => $customClass . ' ' . $colspanClass,
]) }}>
    <div class="filament-forms-field-wrapper">
        <div class="space-y-2">
            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse"
                    for="form_IF.nama_dokter">
                    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                        {{ $title }}
                    </span>
                </label>
            </div>
            <div class="filament-forms-placeholder-component">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
