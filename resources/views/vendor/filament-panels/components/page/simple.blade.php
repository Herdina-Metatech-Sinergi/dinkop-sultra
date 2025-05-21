@props([
    'heading' => null,
    'subheading' => null,
])

<div {{ $attributes->class(['fi-simple-page']) }}>
    <section class="grid auto-cols-fr gap-y-6">
        <x-filament-panels::header.simple
            :heading="$heading ??= $this->getHeading()"
            :logo="$this->hasLogo()"
            :subheading="$subheading ??= $this->getSubHeading()"
        />

        {{ $slot }}

        <p style="font-size: 12px">Cek Anggota <a href="{{url('/admin/cek-anggota')}}">Disini</a></p>
        <p style="font-size: 12px">
            Jika mengalami kendala, silakan <a href="https://wa.me/6285186060059" target="_blank">hubungi admin via WhatsApp disini</a>.
        </p>
        <p style="font-size: 12px">Copyright © {{date('Y')}} <a href="{{url('/')}}">Aplikasi Laporan Keuangan Koperasi Simpan Pinjam (USP)</a> | <a href="https://hdnmetatech.com" target="__blank">HMS</a></p>
    </section>

    @if (! $this instanceof \Filament\Tables\Contracts\HasTable)
        <x-filament-actions::modals />
    @endif
</div>
