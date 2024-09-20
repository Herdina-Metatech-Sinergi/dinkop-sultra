<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <form wire:submit="create">
        {{ $this->form }}

        <p><br></p>
        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
            wire:click="submit()">
            <x-slot:custom_svg>
                <x-button.svg.save />
            </x-slot:custom_svg>
            Simpan
        </x-button.button>
    </form>
    <x-filament-actions::modals />
    <br>
    <hr>
    <br>
    <div>
        {{ $this->table }}
    </div>
</div>
