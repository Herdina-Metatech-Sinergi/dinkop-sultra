<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">
                <a
                    href="{{url('/')}}"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    {{env('APP_NAME')}}
                </a>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    {{date('Y')}} - {{ \Composer\InstalledVersions::getPrettyVersion('filament/filament') }}
                </p>
            </div>

            <div class="flex flex-col items-end gap-y-1">

            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
