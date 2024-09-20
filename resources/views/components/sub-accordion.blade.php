@props([
    'id' => 'accordion',
    'title' => 'accordion',
    'defaultValue' => 'false',
    'customClass' => null,
    'svg' => null,
])

<div class="container text-grey mx-auto">
    <div class="leading-loose mt-6">
        <div>
            <div class="w-full font-bold flex justify-between items-center mt-4 border-b border-gray-400"
                @click="isOpen_{{ $id }} = !isOpen_{{ $id }}">
                <div class="flex justify-between items-center">
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
                    <div class="px-2">{{ $title }}</div>
                </div>
                <div></div>
            </div>

            <div class="text-sm mt-2">
                <div class="mt-5 mb-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
