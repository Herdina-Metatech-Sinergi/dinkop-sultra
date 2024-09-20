@props([
    'customClass' => '',
    'th' => '',
    'row' => '',
    'slot' => '',
    'tableHeaderMsg' => '',
    'tableFooterMsg' => '',
    'font_size' => 'text-xs',
    'striped_table' => '', //sebagai props striped table
])

<div {{ $attributes->merge([
    'class' => '' . $customClass,
]) }}>
    <div class="flex flex-row justify-center">
        {{ $action_container ?? '' }}
    </div>

    <div class="overflow-x-auto">
        <div class="inline-block min-w-full"  style="width: 100%">
            <span class="text-sm">
                {{ $tableHeaderMsg }}
            </span>

            <table
                class="border-collapse border border-slate-500 min-w-full text-left {{ $font_size }} {{ $striped_table }}" style="width: 100%">
                <thead class="border-collapse border bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        {{ $th ?? '' }}
                    </tr>
                </thead>
                <tbody>
                    {{ $row }}
                </tbody>
            </table>

            <span class="text-sm">
                {{ $tableFooterMsg }}
            </span>
        </div>
    </div>

    <style>
        /* Gaya untuk mode terang */
        table.striped-table tbody tr:nth-child(even) {
            background-color: #ececec;
        }

        /* Gaya untuk mode gelap */
        .dark table.striped-table tbody tr:nth-child(even) {
            background-color: #313f53;
        }
    </style>
</div>
