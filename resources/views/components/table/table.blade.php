<div
    class="{{$customClass}} border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-header-container" x-show="hasHeader = (true || selectedRecords.length)">
        <div class="px-2 pt-2">
            <div class="filament-tables-header px-4 py-2 mb-2">
                <div class="flex flex-col gap-4 md:justify-between md:items-start md:flex-row md:-mr-2">
                    <div>
                        <h2 class="filament-tables-header-heading text-xl font-bold tracking-tight">
                            {{ $title ?? '' }}
                        </h2>

                        <p class="filament-tables-header-description">
                            {{ $subtitle ?? '' }}
                        </p>
                    </div>

                    <div
                        class="filament-tables-actions-container flex items-center gap-4 flex-wrap justify-end shrink-0">
                        {{ $action_container ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 border-t"
        x-bind:class="{
            'rounded-t-xl': !hasHeader,
            'border-t': hasHeader,
        }">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-500/5">
                    {{ $th ?? '' }}
                </tr>
            </thead>

            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                {{ $row }}
            </tbody>
        </table>
    </div>
</div>
