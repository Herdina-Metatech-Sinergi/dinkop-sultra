<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' =>
            'filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-' .
            $color .
            '-600 hover:bg-' .
            $color .
            '-500 focus:bg-' .
            $color .
            '-700 focus:ring-offset-' .
            $color .
            '-700 filament-page-button-action',
    ]) }}>
    <span class="flex items-center gap-1">
        {{ $custom_svg ?? '' }}
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="animate-spin filament-button-icon w-5 h-5 mr-1 -ml-2 rtl:ml-1 rtl:-mr-2"
            wire:loading.delay="wire:loading.delay" style="display: none;">
            <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
                d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                fill="currentColor"></path>
            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
        </svg>
        <span>
            {{ $slot }}
        </span>
    </span>
</button>
