<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

@props([
    'customClass' => '',
    'customStyle' => '',
    'placeholder' => '',
    'type' => 'text',
    'list' => '',
    'readonly' => false,
])
<input style="{{ $customStyle }}"
    {{ $attributes->merge([
        'list' => $list,
        'type' => $type,
        'placeholder' => $placeholder,
        'disabled' => $readonly,
        'readonly' => $readonly,
        'class' =>
            $customClass .
            ' px-1 py-1 placeholder-slate-300 relative bg-white rounded text-sm border-1 shadow outline-none focus:outline-none focus:ring w-full dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600',
    ]) }}>
