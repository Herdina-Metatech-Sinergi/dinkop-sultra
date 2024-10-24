<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        @livewire('anggota-koperasi-detail',['anggota_id' => $record->id])

    </x-filament::section>
</x-filament-widgets::widget>

