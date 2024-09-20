@props([
    'id' => 'accordion',
    'title' => 'accordion',
    'defaultValue' => 'false',
    'customClass' => null,
    'svg' => null,
])

<div class="mx-auto">
    <div x-data="{ isOpen_{{ $id }}: {{ $defaultValue }} }" class="shadow-md rounded-md">
        <button class="w-full flex justify-between items-center p-4 border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-800"
            @click="isOpen_{{ $id }} = !isOpen_{{ $id }}">
            <div class="flex items-center">
                @if ($svg == null)
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="16"
                        height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                        <path d="M9 7l6 0" />
                        <path d="M9 11l6 0" />
                        <path d="M9 15l4 0" />
                    </svg>
                @else
                    {{ $svg }}
                @endif
                <div class="ml-2">{{ $title }}</div>
            </div>
            <div class="flex items-center">
                <svg x-show="!isOpen_{{ $id }}" xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-maximize" width="16" height="16" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                    <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                </svg>
                <svg x-show="isOpen_{{ $id }}" xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-minimize" width="16" height="16" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 19v-2a2 2 0 0 1 2 -2h2" />
                    <path d="M15 5v2a2 2 0 0 0 2 2h2" />
                    <path d="M5 15h2a2 2 0 0 1 2 2v2" />
                    <path d="M5 9h2a2 2 0 0 0 2 -2v-2" />
                </svg>
            </div>
        </button>

        <div x-show="isOpen_{{ $id }}" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-[-10px]" class="p-4 dark:text-white bg-gray-50 dark:bg-gray-900">
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
