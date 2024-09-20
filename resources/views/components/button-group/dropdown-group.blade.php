<div
    {{ $attributes->merge([
        'class' => 'filament-tables-actions-container flex items-center gap-4 justify-center',
    ]) }}>
    <div class="filament-dropdown" x-data="{
        toggle: function(event) {
            $refs.panel.toggle(event)
        },
        open: function(event) {
            $refs.panel.open(event)
        },
        close: function(event) {
            $refs.panel.close(event)
        },
    }">
        <div x-on:click="toggle" class="filament-dropdown-trigger cursor-pointer" aria-expanded="false">
            <button type="button"
                class="filament-icon-button flex items-center justify-center rounded-full relative outline-none hover:bg-gray-500/5 disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none text-primary-500 focus:bg-primary-500/10 dark:hover:bg-gray-300/5 w-10 h-10">
                <svg wire:loading.remove.delay="" wire:target="" class="filament-icon-button-icon w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                    </path>
                </svg>
            </button>
        </div>

        <div x-ref="panel" x-float.placement.bottom-end.flip.teleport.offset="{ offset: 8 }"
            x-transition:enter-start="opacity-0 scale-95" x-transition:leave-end="opacity-0 scale-95"
            class="filament-dropdown-panel absolute z-10 w-full divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-black/5 transition dark:divide-gray-700 dark:bg-gray-800 dark:ring-white/10 max-w-[14rem]"
            style="position: fixed; display: none; left: 1035px; top: 425.5px;">
            <div class="filament-dropdown-list p-1">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
