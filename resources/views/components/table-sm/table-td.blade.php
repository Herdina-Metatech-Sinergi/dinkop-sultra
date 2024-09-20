@props([
    'colspan' => 1,
    'rowspan' => 1,
    'customClass' => '',
    'customStyle' => '',
    'wrapClass' => 'whitespace-normal', //or break-all
    'freeze' => false, //freeze kolom
    'stickyPos' => '', //freeze kolom
])

<style>
    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        white-space: normal;
        /* Mengatur teks agar dipecah menjadi beberapa baris */
        word-wrap: break-word;
        /* Jika kata terlalu panjang */
        word-break: break-all;
        /* Memecah kata dan karakter */
    }

    .first-col-sticky {
        width: 5em;
        min-width: 5em;
        max-width: 5em;
        left: 0em;
        z-index: 1;
    }

    .second-col-sticky {
        width: 10em;
        min-width: 10em;
        max-width: 10em;
        left: 5em;
        z-index: 1;
    }
</style>

<td style="{{ $customStyle }}" colspan="{{ $colspan }}" rowspan="{{ $rowspan }}"
    class="border-collapse border {{ $wrapClass }} px-1 py-1 max-w-xs {{ $freeze ? 'sticky-col bg-white dark:bg-gray-800' : '' }} {{ $stickyPos }} {{ $customClass }}">
    {{ $slot }}
</td>
