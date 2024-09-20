<div {{ $attributes->merge([
    'class' => 'col-span-full',
]) }}>
    <div class="filament-forms-field-wrapper">
        <label class="sr-only">
            Shout Error
        </label>
        <div class="space-y-2">
            <div role="alert"
                class="shout-component border rounded-lg p-4 bg-info-100 border-info-300 text-info-900 dark:border-info-300 dark:bg-info-200">
                <div class="flex">
                    <div class="flex-shrink-0 ltr:mr-3 rtl:ml-3 text-info-500">
                        <svg class="shout-icon h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
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
