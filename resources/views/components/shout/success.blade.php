<div {{ $attributes->merge([
    'class' => 'col-span-full',
]) }}>
    <div class="filament-forms-field-wrapper">
        <label class="sr-only">
            Shout Error
        </label>
        <div class="space-y-2">
            <div role="alert"
                class="shout-component border rounded-lg p-4 bg-success-200 border-success-300 text-success-900 dark:border-success-300 dark:bg-success-200">
                <div class="flex">
                    <div class="flex-shrink-0 ltr:mr-3 rtl:ml-3 text-success-500">
                        <svg class="shout-icon h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
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
