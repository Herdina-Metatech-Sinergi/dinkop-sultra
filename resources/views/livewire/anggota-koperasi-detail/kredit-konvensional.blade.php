<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    <form wire:submit.prevent="submitKredit">
        {{ $this->formKreditKonvensional }}
        <p><br></p>
        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
            wire:click="submitKredit()">
            <x-slot:custom_svg>
                <x-button.svg.save />
            </x-slot:custom_svg>
            Submit
        </x-button.button>
    </form>
    <p><br></p>

    <x-table-sm.table title="" subtitle="" customClass=''>
        <x-slot:th>
            <x-table-sm.table-th customClass='text-center'>
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Kredit
            </x-table-sm.table-th>
            {{-- <x-table-sm.table-th customClass='text-center'>
                No Pinjaman
            </x-table-sm.table-th> --}}
            <x-table-sm.table-th customClass='text-right'>
                Nominal Pinjaman
            </x-table-sm.table-th>


            <x-table-sm.table-th customClass='text-right'>
                Suku Jasa per Bulan (%)
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-right'>
                Angsuran/Bulan
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-right'>
                Angsuran/Bulan Berikutnya
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Tenor (bulan)
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Aksi
            </x-table-sm.table-th>

        </x-slot:th>
        <x-slot:row>
            @forelse ($kredit ?? [] as $data)
                <div>
                    <x-table-sm.table-tr>
                        <x-table-sm.table-td customClass="text-center">
                            <x-button.button-text color="gray"
                                wire:click="goToggleShowKredit({{ $data['id'] }})">
                                <x-slot:custom_svg>
                                    @if (in_array($data['id'], $index_open_kredit))
                                        <x-button.svg.minus customClass="ml-0" />
                                    @else
                                        <x-button.svg.plus customClass="ml-0" />
                                    @endif
                                </x-slot:custom_svg>
                            </x-button.button-text>
                        </x-table-sm.table-td>
                        <x-table-sm.table-td>
                            {{ $data['kredit'] }}
                        </x-table-sm.table-td>
                        {{-- <x-table-sm.table-td customClass="text-center">
                            {{ $data['keterangan'] }}
                        </x-table-sm.table-td> --}}
                        <x-table-sm.table-td>
                            {{ App\Http\Controllers\Controller::rupiah(@$data['pinjaman_pokok']) }}
                        </x-table-sm.table-td>
                        <x-table-sm.table-td>
                            {{ @$data['tarif_layanan'] }} %
                        </x-table-sm.table-td>
                        <x-table-sm.table-td>
                            {{ App\Http\Controllers\Controller::rupiah(@$data['angsuran_pokok_pertama']) }}
                        </x-table-sm.table-td>
                        <x-table-sm.table-td>
                            {{ App\Http\Controllers\Controller::rupiah(@$data['angsuran_pokok_berikutnya']) }}
                        </x-table-sm.table-td>
                        <x-table-sm.table-td>
                            {{ @$data['jangka_waktu'] }}
                        </x-table-sm.table-td>
                        <x-table-sm.table-td>
                            <x-button.button-only-edit color="warning"
                                wire:click="goUbahItemKredit({{ $data['id'] }})"
                                wire:loading.attr="disabled"
                                wire:loading.class.delay="opacity-70 cursor-wait">
                            </x-button.button-only-edit>
                            <x-button.button-only-delete color="danger"
                                onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                wire:click="goHapusItemKredit({{ $data['id'] }})"
                                wire:loading.attr="disabled"
                                wire:loading.class.delay="opacity-70 cursor-wait">
                            </x-button.button-only-delete>
                        </x-table-sm.table-td>
                    </x-table-sm.table-tr>

                    @php
                        $_is_hidden = 'hidden';
                        if (in_array($data['id'], $index_open_kredit)) {
                            $_is_hidden = '';
                        }
                    @endphp
                    <x-table-sm.table-tr customClass="{{ $_is_hidden }}"
                        wire:key="{{ 'tabDetailKredit' . @$data['id'] }}">
                        <x-table-sm.table-td colspan='999' customStyle='background-color: rgba(30, 136, 229, 0.3);'>

                            <x-table-sm.table title="" subtitle="" customClass='mt-0'>
                                <x-slot:th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Tgl
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Hari Ke
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Jumlah Hari
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Pokok
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Angsuran
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Angsuran Pokok
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Status Pokok
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Angsuran Jasa
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Status Jasa
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Baki Debet
                                    </x-table-sm.table-th>
                                    <x-table-sm.table-th customClass='text-center'>
                                        Aksi
                                    </x-table-sm.table-th>
                                </x-slot:th>

                                <x-slot:row>
                                    @php
                                        $total_kredit = 0;
                                        $total_kredit_lunas = 0;
                                    @endphp
                                    @forelse ($data['kredit_konvensional_angsuran'] as $data2)
                                        <x-table-sm.table-tr>
                                            <x-table-sm.table-td>
                                                {{ @$data2['tanggal_jatuh_tempo'] }}
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td>
                                                {{ @$data2['angsuran_ke'] }}
                                            </x-table-sm.table-td>
                                            <x-table-sm.table-td>
                                                {{ @$data2['jumlah_hari'] }}
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td class='text-right'>
                                                {{ App\Http\Controllers\Controller::rupiah(@$data2['pokok']) }}
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td class='text-right'>
                                                {{ App\Http\Controllers\Controller::rupiah(@$data2['jumlah_angsuran']) }}
                                            </x-table-sm.table-td>
                                            <x-table-sm.table-td class='text-right'>
                                                {{ App\Http\Controllers\Controller::rupiah(@$data2['angsuran_pokok']) }}
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td>
                                                {{ @$data2['status_pokok'] }}
                                                @php
                                                    if ($data2['status_pokok'] == 'Lunas') {
                                                        $total_kredit_lunas += $data2['angsuran_pokok'];
                                                    }
                                                    $total_kredit += $data2['angsuran_pokok'];
                                                @endphp
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td class='text-right'>
                                                {{ App\Http\Controllers\Controller::rupiah(@$data2['angsuran_bunga']) }}
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td>
                                                {{ @$data2['status_bunga'] }}
                                                @php
                                                    if ($data2['status_bunga'] == 'Lunas') {
                                                        $total_kredit_lunas += $data2['angsuran_bunga'];
                                                    }
                                                    $total_kredit += $data2['angsuran_bunga'];
                                                @endphp
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td class='text-right'>
                                                {{ App\Http\Controllers\Controller::rupiah($data2['baki_debet']) }}
                                            </x-table-sm.table-td>

                                            <x-table-sm.table-td class='text-center'>
                                                @if ($data2['status_pokok'] != 'Lunas')
                                                    <x-button.button-only-add color="danger"
                                                        onclick="confirm('Bayar angsuran pokok?') || event.stopImmediatePropagation()"
                                                        wire:click="goBayarAngsuranPokok({{ $data2['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        wire:loading.class.delay="opacity-70 cursor-wait">
                                                    </x-button.button-only-add>
                                                    Bayar Pokok
                                                @endif

                                                @if ($data2['status_bunga'] != 'Lunas')
                                                    <x-button.button-only-add color="danger"
                                                        onclick="confirm('Bayar angsuran bunga?') || event.stopImmediatePropagation()"
                                                        wire:click="goBayarAngsuranJasa({{ $data2['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        wire:loading.class.delay="opacity-70 cursor-wait">
                                                    </x-button.button-only-add>
                                                    Bayar Bunga
                                                @endif
                                            </x-table-sm.table-td>
                                        </x-table-sm.table-tr>
                                    @empty
                                        <x-table-sm.table-tr>
                                            <x-table-sm.table-td-full-colspan>
                                                Data kosong
                                            </x-table-sm.table-td-full-colspan>
                                        </x-table-sm.table-tr>
                                    @endforelse


                                    <x-table-sm.table-tr>
                                        <x-table-sm.table-td colspan='9' customClass='border-0 text-right font-bold'>
                                            Total
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                            {{ App\Http\Controllers\Controller::rupiah($total_kredit) }}
                                        </x-table-sm.table-td>
                                    </x-table-sm.table-tr>

                                    <x-table-sm.table-tr>
                                        <x-table-sm.table-td colspan='9' customClass='border-0 text-right font-bold'>
                                            Total Lunas
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                            {{ App\Http\Controllers\Controller::rupiah($total_kredit_lunas) }}
                                        </x-table-sm.table-td>
                                    </x-table-sm.table-tr>

                                    <x-table-sm.table-tr>
                                        <x-table-sm.table-td colspan='9' customClass='border-0 text-right font-bold'>
                                            Total Hutang
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                            {{ App\Http\Controllers\Controller::rupiah($total_kredit - $total_kredit_lunas) }}
                                        </x-table-sm.table-td>
                                    </x-table-sm.table-tr>
                                </x-slot:row>
                            </x-table-sm.table>


                        </x-table-sm.table-td>
                    </x-table-sm.table-tr>
                </div>
            @empty
                <x-table-sm.table-tr>
                    <x-table-sm.table-td-full-colspan>
                        Data kosong
                    </x-table-sm.table-td-full-colspan>
                </x-table-sm.table-tr>
            @endforelse

        </x-slot:row>
    </x-table-sm.table>
</div>
