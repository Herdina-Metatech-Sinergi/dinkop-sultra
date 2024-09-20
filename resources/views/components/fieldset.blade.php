<div class="{{ $customClass }} col-span-full">
    <fieldset
        class="filament-forms-fieldset-component rounded-xl shadow-sm border border-gray-300 p-6 dark:border-gray-600 dark:text-gray-200">
        <legend class="text-sm leading-tight font-medium px-2 -ml-2">
            {{ $title }}
        </legend>

        {{ $slot }}
    </fieldset>
</div>
