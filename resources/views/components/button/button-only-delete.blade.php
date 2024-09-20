<button
    {{ $attributes->merge([
        'title' => 'Delete',
        'type' => 'button',
        'class' =>
            'filament-icon-button flex items-center justify-center rounded-full relative outline-none hover:bg-gray-500/5 disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none text-' .
            $color .
            '-500 focus:bg-' .
            $color .
            '-500/10 dark:hover:bg-gray-300/5 w-10 h-10',
    ]) }}>
    <span class="sr-only">
        Delete
    </span>

    <svg wire:loading.remove.delay="1" class="filament-icon-button-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd"
            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
    </svg>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="animate-spin filament-dropdown-list-item-icon h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-{{ $color }}-500"
        wire:loading.delay="wire:loading.delay">
        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
            d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
            fill="currentColor"></path>
        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
    </svg>
</button>
