<div {{ $attributes->merge([
    'class' => 'col-span-full',
]) }}>
    <div class="filament-forms-field-wrapper">
        <label class="sr-only">
            Shout Error
        </label>
        <div class="space-y-2">
            <div role="alert"
                class="shout-component border rounded-lg p-4 bg-danger-100 border-danger-300 text-danger-900 dark:border-danger-300 dark:bg-danger-200">
                <div class="flex">
                    <div class="flex-shrink-0 ltr:mr-3 rtl:ml-3 text-danger-500">
                        <svg class="shout-icon h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
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
