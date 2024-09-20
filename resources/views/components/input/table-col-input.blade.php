<input
    {{ $attributes->merge([
        'type' => $type,
        'class' =>
            'ml-0.5 text-gray-900 inline-block transition duration-75 rounded-lg shadow-sm outline-none focus:ring-primary-500 focus:ring-1 focus:ring-inset focus:border-primary-500 disabled:opacity-70 read-only:opacity-50 text-left dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600',
    ]) }}>
