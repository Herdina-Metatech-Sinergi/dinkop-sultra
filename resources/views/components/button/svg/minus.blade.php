@props([
    'customClass' => '',
])

<svg wire:loading.remove.delay="1" xmlns="http://www.w3.org/2000/svg"
    class="filament-button-icon w-5 h-5 mr-1 -ml-2 rtl:ml-1 rtl:-mr-2 {{ $customClass }}" width="24" height="24"
    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <path
        d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-4 9h-6l-.117 .007a1 1 0 0 0 .117 1.993h6l.117 -.007a1 1 0 0 0 -.117 -1.993z"
        stroke-width="0" fill="currentColor"></path>
</svg>
