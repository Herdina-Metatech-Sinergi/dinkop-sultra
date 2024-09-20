<div {{ $attributes->merge([
    'class' => 'col-span-full',
]) }}>
    <div class="filament-forms-field-wrapper">
        <label class="sr-only">
            Shout Warning
        </label>
        <div class="space-y-2">
            <div role="alert"
                class="shout-component border rounded-lg p-4 bg-warning-100 border-warning-300 text-warning-900 dark:border-warning-300 dark:bg-warning-200">
                <div class="flex">
                    <div class="flex-shrink-0 ltr:mr-3 rtl:ml-3 text-warning-500">
                        <svg class="shout-icon h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="text-sm font-medium">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
