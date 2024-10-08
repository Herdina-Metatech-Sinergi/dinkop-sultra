<div>
    {{-- Success is as dangerous as failure. --}}

<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}


    <div class="mt-5">
        {{ $this->formHeader }}
        <p><br></p>

    </div>

    {{-- TABS --}}
    <div class="mt-5">
        <x-tab.tab tab="tabAnggota" defaultTab="tabcon-simpanan-pokok">
            <x-slot:navButton>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan-pokok">
                    Simpanan Pokok
                </x-tab.nav-button>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan-wajib">
                    Simpanan Wajib
                </x-tab.nav-button>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan-sukarela">
                    Simpanan Sukarela
                </x-tab.nav-button>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-kredit">
                    Kredit
                </x-tab.nav-button>

            </x-slot:navButton>
            <x-slot:tabContainer>
                <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan-pokok">
                    <form wire:submit="create">
                        {{ $this->formSimpananPokok }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitSimpananPokok()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Simpan
                        </x-button.button>
                    </form>
                    <x-table-sm.table title="" subtitle="Simpanan Pokok" customClass='mt-5'>

                        <x-slot:th>
                            <x-table-sm.table-th>
                                Tanggal
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Deskripsi
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Debet
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Kredit
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Saldo
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Aksi
                            </x-table-sm.table-th>

                        </x-slot:th>
                        <x-slot:row>

                        @php
                            $total = 0;
                        @endphp
                            @forelse ($simpanan_pokok ?? [] as $data)

                                <x-table-sm.table-tr>
                                    <x-table-sm.table-td>
                                        {{ @$data['tanggal'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td>
                                        {{ @$data['deskripsi'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Debet')
                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}

                                        @endif
                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Kredit')
                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}

                                        @endif
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Debet')
                                        @php
                                            $total += $data['nominal'];

                                        @endphp
                                        @endif
                                        @if ($data['d_k'] == 'Kredit')
                                        @php
                                            $total -= $data['nominal'];

                                        @endphp
                                        @endif
                                        {{ App\Http\Controllers\Controller::rupiah(@$total) }}

                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td>
                                        <x-button.button-only-edit color="warning"
                                            wire:click="goUbahItemSimpananPokok({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-edit>
                                        <x-button.button-only-delete color="danger"
                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                            wire:click="goHapusItemSimpananPokok({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-delete>
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
                                <x-table-sm.table-td colspan='4' customClass='border-0 text-right font-bold'>
                                    Total
                                </x-table-sm.table-td>
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    {{App\Http\Controllers\Controller::rupiah($total)}}
                                </x-table-sm.table-td>
                            </x-table-sm.table-tr>
                        </x-slot:row>
                    </x-table-sm.table>
                </x-tab.tab-container>

                <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan-wajib">
                    <form wire:submit="create">
                        {{ $this->formSimpananWajib }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitSimpananWajib()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Simpan
                        </x-button.button>
                    </form>
                    <x-table-sm.table title="" subtitle="Simpanan Wajib" customClass='mt-5'>

                        <x-slot:th>
                            <x-table-sm.table-th>
                                Tanggal
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Deskripsi
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Debet
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Kredit
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Saldo
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Aksi
                            </x-table-sm.table-th>

                        </x-slot:th>
                        <x-slot:row>
                            @php
                                $total_simwa = 0;
                            @endphp
                            @forelse ($simpanan_wajib ?? [] as $data)

                                <x-table-sm.table-tr>
                                    <x-table-sm.table-td>
                                        {{ @$data['tanggal'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td>
                                        {{ @$data['deskripsi'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Debet')
                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}

                                        @endif
                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Kredit')
                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}

                                        @endif
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Debet')
                                        @php
                                            $total_simwa += $data['nominal'];

                                        @endphp
                                        @endif
                                        @if ($data['d_k'] == 'Kredit')
                                        @php
                                            $total_simwa -= $data['nominal'];

                                        @endphp
                                        @endif
                                        {{ App\Http\Controllers\Controller::rupiah(@$total_simwa) }}

                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td>
                                        <x-button.button-only-edit color="warning"
                                            wire:click="goUbahItemSimpananWajib({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-edit>
                                        <x-button.button-only-delete color="danger"
                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                            wire:click="goHapusItemSimpananWajib({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-delete>
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
                                <x-table-sm.table-td colspan='4' customClass='border-0 text-right font-bold'>
                                    Total
                                </x-table-sm.table-td>
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    {{App\Http\Controllers\Controller::rupiah($total_simwa)}}
                                </x-table-sm.table-td>
                            </x-table-sm.table-tr>
                        </x-slot:row>
                    </x-table-sm.table>
                </x-tab.tab-container>

                <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan-sukarela">
                    <form wire:submit="create">
                        {{ $this->formSimpananSukarela }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitSimpananSukarela()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Simpan
                        </x-button.button>
                    </form>
                    <x-table-sm.table title="" subtitle="Simpanan Sukarela" customClass='mt-5'>

                        <x-slot:th>
                            <x-table-sm.table-th>
                                Tanggal
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Deskripsi
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Debet
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Kredit
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Saldo
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Aksi
                            </x-table-sm.table-th>

                        </x-slot:th>
                        <x-slot:row>
                            @php
                            $total_simsuk = 0;
                        @endphp
                            @forelse ($simpanan_sukarela ?? [] as $data)

                                <x-table-sm.table-tr>
                                    <x-table-sm.table-td>
                                        {{ @$data['tanggal'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td>
                                        {{ @$data['deskripsi'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Debet')
                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}

                                        @endif
                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Kredit')
                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}

                                        @endif
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td customClass='text-right'>
                                        @if ($data['d_k'] == 'Debet')
                                        @php
                                            $total_simsuk += $data['nominal'];

                                        @endphp
                                        @endif
                                        @if ($data['d_k'] == 'Kredit')
                                        @php
                                            $total_simsuk -= $data['nominal'];

                                        @endphp
                                        @endif
                                        {{ App\Http\Controllers\Controller::rupiah(@$total_simsuk) }}

                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td>
                                        <x-button.button-only-edit color="warning"
                                            wire:click="goUbahItemSimpananSukarela({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-edit>
                                        <x-button.button-only-delete color="danger"
                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                            wire:click="goHapusItemSimpananSukarela({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-delete>
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
                                <x-table-sm.table-td colspan='4' customClass='border-0 text-right font-bold'>
                                    Total
                                </x-table-sm.table-td>
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    {{App\Http\Controllers\Controller::rupiah($total_simsuk)}}
                                </x-table-sm.table-td>
                            </x-table-sm.table-tr>
                        </x-slot:row>
                    </x-table-sm.table>
                </x-tab.tab-container>

                <x-tab.tab-container tab="tabAnggota" id="tabcon-kredit">
                    <form wire:submit="create">
                        {{ $this->formKredit }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitKredit()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Submit
                        </x-button.button>
                    </form>

                    <x-table-sm.table title="" subtitle="" customClass=''>
                        <x-slot:th>
                            <x-table-sm.table-th customClass='text-center'>
                            </x-table-sm.table-th>
                            <x-table-sm.table-th customClass='text-center'>
                                Kredit
                            </x-table-sm.table-th>
                            <x-table-sm.table-th customClass='text-center'>
                                Keterangan
                            </x-table-sm.table-th>
                            <x-table-sm.table-th customClass='text-right'>
                                Nominal Pinjaman
                            </x-table-sm.table-th>
                            <x-table-sm.table-th customClass='text-right'>
                                DP
                            </x-table-sm.table-th>
                            <x-table-sm.table-th customClass='text-right'>
                                Nominal Pinjaman + Margin
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
                                        <x-table-sm.table-td customClass="text-center">
                                            {{ $data['keterangan'] }}
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td>
                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal_pinjaman']) }}
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td>
                                            {{ App\Http\Controllers\Controller::rupiah(@$data['dp']) }}
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td>
                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal_pinjaman_margin']) }}
                                        </x-table-sm.table-td>
                                        <x-table-sm.table-td>
                                            {{ @$data['tenor'] }}
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
                                                        Angsuran
                                                    </x-table-sm.table-th>
                                                    <x-table-sm.table-th customClass='text-center'>
                                                        Status
                                                    </x-table-sm.table-th>
                                                    <x-table-sm.table-th customClass='text-center'>
                                                        Nominal
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
                                                    @forelse ($data['kredit_angsuran'] ?? [] as $data2)
                                                        <x-table-sm.table-tr>
                                                            <x-table-sm.table-td>
                                                                {{ @$data2['tgl'] }}
                                                            </x-table-sm.table-td>

                                                            <x-table-sm.table-td>
                                                                {{ @$data2['angsuran'] }}
                                                            </x-table-sm.table-td>
                                                            <x-table-sm.table-td>
                                                                {{ @$data2['status'] }}
                                                                @php
                                                                    if ($data2['status'] == 'Lunas') {
                                                                        # code...
                                                                        $total_kredit_lunas += $data2['nominal'];
                                                                    }
                                                                    $total_kredit += $data2['nominal'];
                                                                @endphp
                                                            </x-table-sm.table-td>

                                                            <x-table-sm.table-td wrapClass="break-all"
                                                                customClass='text-end'>
                                                                {{ App\Http\Controllers\Controller::rupiah($data2['nominal'] ?? '0') }}
                                                            </x-table-sm.table-td>
                                                            <x-table-sm.table-td customClass='text-center'>
                                                                @if ($data2['status'] != 'Lunas' )
                                                                <x-button.button-only-add color="danger"
                                                                    onclick="confirm('Bayar angsuran?') || event.stopImmediatePropagation()"
                                                                    wire:click="goBayarItemKreditAngsuran({{ $data2['id'] }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:loading.class.delay="opacity-70 cursor-wait">
                                                                    Bayar
                                                                </x-button.button-only-add>
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
                                                        <x-table-sm.table-td colspan='3' customClass='border-0 text-right font-bold'>
                                                            Total
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                                            {{App\Http\Controllers\Controller::rupiah($total_kredit)}}
                                                        </x-table-sm.table-td>
                                                    </x-table-sm.table-tr>

                                                    <x-table-sm.table-tr>
                                                        <x-table-sm.table-td colspan='3' customClass='border-0 text-right font-bold'>
                                                            Total Lunas
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                                            {{App\Http\Controllers\Controller::rupiah($total_kredit_lunas)}}
                                                        </x-table-sm.table-td>
                                                    </x-table-sm.table-tr>

                                                    <x-table-sm.table-tr>
                                                        <x-table-sm.table-td colspan='3' customClass='border-0 text-right font-bold'>
                                                            Total Hutang
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                                            {{App\Http\Controllers\Controller::rupiah($total_kredit - $total_kredit_lunas)}}
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

                </x-tab.tab-container>
            </x-slot:tabContainer>
        </x-tab.tab>
    </div>


</div>

</div>
