@props([
    'customClass' => '',
])
<button
    {{ $attributes->merge([
        'type' => 'button',
        'size' => 'sm',
        'class' =>
            'filament-dropdown-list-item filament-dropdown-item group flex w-full items-center whitespace-nowrap rounded-md p-2 text-sm outline-none hover:text-white focus:text-white hover:bg-primary-500 focus:bg-primary-500 filament-tables-grouped-action' .
            $customClass,
    ]) }}
    wire:loading.attr="disabled"
    wire:loading.class.delay="opacity-70 cursor-wait">
    <svg wire:loading.remove.delay="1"
        class="filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-primary-500"
        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10">
        </circle>
        <line x1="12" y1="8" x2="12" y2="16">
        </line>
        <line x1="8" y1="12" x2="16" y2="12">
        </line>
    </svg>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="animate-spin filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-primary-500"
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
