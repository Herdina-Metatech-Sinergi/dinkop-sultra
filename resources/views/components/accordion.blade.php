@props([
    'id' => 'accordion',
    'title' => 'accordion',
    'defaultIsOpen' => 'false',
    'customClass' => null,
    'svg' => null,
])

<div class="container text-grey mx-auto px-2">
    <div class="leading-loose mt-6">
        <div x-data="{ isOpen_{{ $id }}: {{ $defaultIsOpen }} }">
            <button class="w-full font-bold flex justify-between items-center mt-4 border-b border-gray-400"
                @click="isOpen_{{ $id }} = !isOpen_{{ $id }}">
                <div class="flex justify-between items-center">
                    @if ($svg == null)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 8h18" />
                            <path d="M3 16h18" />
                            <path d="M8 3v18" />
                            <path d="M16 3v18" />
                        </svg>
                    @else
                        {{ $svg }}
                    @endif
                    <div class="px-2">{{ $title }}</div>
                </div>
                <svg x-show="!isOpen_{{ $id }}" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                    <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                </svg>
                <svg x-show="isOpen_{{ $id }}" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 24 24" stroke-width="2" stroke="red" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                </svg>
            </button>

            <div x-show="isOpen_{{ $id }}" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-[-10px]"
                class="text-sm border-l border-r border-b border-gray-400">
                <div class="p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
