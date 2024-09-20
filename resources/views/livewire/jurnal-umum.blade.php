<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
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
    <hr>
    <br>
    <form wire:submit="create">
        {{ $this->createForm }}

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
@push('scripts')
<script>
    Livewire.on('download-export', (url) => {
        window.open(url, '_blank');
    });
    </script>
@endpush
