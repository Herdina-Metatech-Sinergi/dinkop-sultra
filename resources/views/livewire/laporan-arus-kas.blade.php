<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    {{ $this->getFilterFormSchema }}
    <p><br></p>

    <div class="flex flex-row justify-center mt-5">
        <div class="px-2">
            <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                wire:click="exportPDF()">
                <x-slot:custom_svg>
                    <x-button.svg.pdf />
                </x-slot:custom_svg>
                Cetak
            </x-button.button>
        </div>
    </div>
    <br>
</div>
