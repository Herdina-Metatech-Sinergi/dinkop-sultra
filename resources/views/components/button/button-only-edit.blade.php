@props([
    'color' => 'primary',
    'size' => '10',
])

<button
    {{ $attributes->merge([
        'title' => 'Add',
        'type' => 'button',
        'class' =>
            'filament-icon-button flex items-center justify-center rounded-full relative outline-none hover:bg-gray-500/5 disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none text-' .
            $color .
            '-500 focus:bg-' .
            $color .
            '-500/10 dark:hover:bg-gray-300/5 w-' .
            $size .
            ' h-' .
            $size,
    ]) }}>
    <span class="sr-only">
        Edit
    </span>

    <svg wire:loading.remove.delay="1" class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
        </path>
    </svg>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="animate-spin filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-{{ $color }}-500"
        wire:loading.delay="wire:loading.delay">
        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
            d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
            fill="currentColor"></path>
        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
    </svg>
</button>
