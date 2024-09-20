@props([
    'customClass' => '',
    'rows' => '1',
    'cols' => '20',
])
<textarea
    {{ $attributes->merge([
        'rows' => $rows,
        'cols' => $cols,
        'class' =>
            'px-1 py-1 placeholder-slate-300 relative bg-white rounded text-sm border-1 shadow outline-none focus:outline-none focus:ring w-full dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600' .
            $customClass,
    ]) }}>
</textarea>
