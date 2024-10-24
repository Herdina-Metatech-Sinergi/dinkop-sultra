@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])
@php
$brandName = filament()->getBrandName();
$brandLogo = filament()->getBrandLogo()
@endphp
<header class="fi-simple-header">
    @if ($logo)
        <div class="mb-4 flex justify-center">
            {{-- <x-filament-panels::logo /> --}}
            <img
        src="{{ $brandLogo }}"
        loading="lazy"
        alt="{{ $brandName }}"
        {{ $attributes->class(['fi-logo h-10']) }}
    />
    <p style="margin-left: 20px; margin-bottom: 10px;" class="text-xl font-bold">Aplikasi Laporan Keuangan Koperasi Simpan Pinjam (USP)</p>
        </div>
    @endif

    @if (filled($heading))
        <h1
            class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white"
        >
            {{ $heading }}
        </h1>
    @endif

    @if (filled($subheading))
        <p
            class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400"
        >
            {{ $subheading }}
        </p>
    @endif
</header>
