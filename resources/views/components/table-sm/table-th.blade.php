@props([
    'freeze' => false, //freeze kolom
    'stickyPos' => '', //freeze kolom
    'colspan' => 1,
    'customClass' => '',
])

<style>
    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
    }

    .first-col-sticky {
        width: 100px;
        min-width: 100px;
        max-width: 100px;
        left: 0px;
    }

    .second-col-sticky {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 100px;
    }
</style>

<th colspan="{{ $colspan }}" scope="col"
    class="border-collapse border px-1 py-1 {{ $freeze ? 'sticky-col bg-gray-50 dark:bg-gray-700' : '' }} {{ $stickyPos }} {{ $customClass }}">
    {{ $slot }}
</th>
