@props([
    'id' => 'select2default',
    'options' => '',
])

<select
    {{ $attributes->merge([
        'title' => 'Show',
        'type' => 'button',
        'id' => $id,
        'multiple' => 'multiple',
    ]) }}>
    @foreach ($options as $option)
        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
    @endforeach
</select>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#<?= $id ?>').select2();
    });
</script>

{{-- IMPLEMENT --}}
{{-- <x-input.select-2 wire:model='form_RP.pasien_id' id="select-2-1" :options="[['label' => 'tes', 'value' => 1], ['label' => 'wa', 'value' => 2], ['label' => 'wwww', 'value' => 3]]">
</x-input.select-2> --}}