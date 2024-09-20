@props([
    'customClass' => '',
])
<button
    {{ $attributes->merge([
        'type' => 'button',
        'size' => 'sm',
        'class' =>
            'filament-dropdown-list-item filament-dropdown-item group flex w-full items-center whitespace-nowrap rounded-md p-2 text-sm outline-none hover:text-white focus:text-white hover:bg-warning-500 focus:bg-warning-500 filament-tables-grouped-action' .
            $customClass,
    ]) }}
    wire:loading.attr="disabled"
    wire:loading.class.delay="opacity-70 cursor-wait">
    <svg wire:loading.remove.delay="1"
        class="filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-warning-500"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path
            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
        </path>
    </svg>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="animate-spin filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-warning-500"
        wire:loading.delay="wire:loading.delay">
        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
            d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
            fill="currentColor"></path>
        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
    </svg>
    <span class="filament-dropdown-list-item-label truncate w-full text-start">
        {{ $slot }}
    </span>
</button>
