<div>
    {{-- The Master doesn't talk, he acts. --}}
    {{ $this->getFilterFormSchema }}
    <p><br></p>

    <div class="flex flex-row justify-center mt-5">
        <div class="px-2">
            <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                wire:click="viewSHU()">
                <x-slot:custom_svg>
                    <x-button.svg.search />
                </x-slot:custom_svg>
                Lihat
            </x-button.button>
        </div>

    </div>

    <br>
    <x-table-sm.table title="" subtitle="" customClass=''>

        <x-slot:row>
            <x-table-sm.table-tr>

                <x-table-sm.table-th customClass='text-center'>
                    SHU Periode {{$filters['tgl_awal']}} - {{$filters['tgl_akhir']}}
                </x-table-sm.table-th>
                <x-table-sm.table-td>
                    {{ App\Http\Controllers\Controller::rupiah(@$shu) }}
                </x-table-sm.table-td>
            </x-table-sm.table-tr>

            <x-table-sm.table-tr>

                <x-table-sm.table-th customClass='text-center'>
                    SHU Bagian Anggota
                </x-table-sm.table-th>
                <x-table-sm.table-td>
                    {{ App\Http\Controllers\Controller::rupiah(@$shu_bag_anggota) }}
                </x-table-sm.table-td>
            </x-table-sm.table-tr>

            <x-table-sm.table-tr>

                <x-table-sm.table-th customClass='text-center'>
                    SHU Bagian Anggota - Transaksi
                </x-table-sm.table-th>
                <x-table-sm.table-td>
                    {{ App\Http\Controllers\Controller::rupiah(@$shu_transaksi) }}
                </x-table-sm.table-td>
            </x-table-sm.table-tr>

            <x-table-sm.table-tr>

                <x-table-sm.table-th customClass='text-center'>
                    SHU Bagian Anggota - Simpanan
                </x-table-sm.table-th>
                <x-table-sm.table-td>
                    {{ App\Http\Controllers\Controller::rupiah(@$shu_simpanan) }}
                </x-table-sm.table-td>
            </x-table-sm.table-tr>

            <x-table-sm.table-tr>

                <x-table-sm.table-th customClass='text-center'>
                    Total Simpanan
                </x-table-sm.table-th>
                <x-table-sm.table-td>
                    {{ App\Http\Controllers\Controller::rupiah(@$total_simpanan) }}
                </x-table-sm.table-td>
            </x-table-sm.table-tr>

            <x-table-sm.table-tr>

                <x-table-sm.table-th customClass='text-center'>
                    Total Transaksi
                </x-table-sm.table-th>
                <x-table-sm.table-td>
                    {{ App\Http\Controllers\Controller::rupiah(@$total_transaksi) }}
                </x-table-sm.table-td>
            </x-table-sm.table-tr>
        </x-slot:row>

        {{-- </x-slot:th>
        <x-slot:th>


        </x-slot:th> --}}
    </x-table-sm.table>

    <p><br></p>

    <x-table-sm.table title="" subtitle="" customClass='mt-0'>
        <x-slot:th>
            <x-table-sm.table-th customClass='text-center'>
                No Anggota
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Nama
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Total Simpanan
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                SHU Simpanan
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Total Transaksi
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                SHU Transaksi
            </x-table-sm.table-th>

            <x-table-sm.table-th customClass='text-center'>
                SHU Yang Diperoleh
            </x-table-sm.table-th>

        </x-slot:th>

        <x-slot:row>
            @php
                $total_kredit = 0;
                $total_kredit_lunas = 0;
            @endphp
            @forelse ($anggota_koperasi as $data2)
                <x-table-sm.table-tr>
                    <x-table-sm.table-td>
                        {{ @$data2['no_anggota'] }}
                    </x-table-sm.table-td>

                    <x-table-sm.table-td>
                        {{ @$data2['nama'] }}
                    </x-table-sm.table-td>
                    <x-table-sm.table-td>
                        {{ App\Http\Controllers\Controller::rupiah(@$data2['total_simpanan']) }}
                    </x-table-sm.table-td>

                    @php
                        try {
                            //code...
                            $sim = @$data2['total_simpanan'] * @$shu_simpanan / @$total_simpanan;
                        } catch (\Throwable $th) {
                            //throw $th;
                            $sim = 0;
                        }
                    @endphp
                    <x-table-sm.table-td class='text-right'>
                        {{ App\Http\Controllers\Controller::rupiah($sim) }}
                    </x-table-sm.table-td>

                    <x-table-sm.table-td>
                        {{ App\Http\Controllers\Controller::rupiah(@$data2['total_transaksi']) }}
                    </x-table-sm.table-td>
                    @php
                    try {
                        //code...
                        $trans = @$data2['total_transaksi'] * @$shu_transaksi / @$total_transaksi;
                    } catch (\Throwable $th) {
                        //throw $th;
                        $trans = 0;
                    }
                    @endphp
                    <x-table-sm.table-td class='text-right'>
                        {{ App\Http\Controllers\Controller::rupiah(@$trans) }}
                    </x-table-sm.table-td>

                    <x-table-sm.table-td class='text-right'>
                        {{ App\Http\Controllers\Controller::rupiah($trans+$sim) }}
                    </x-table-sm.table-td>


                </x-table-sm.table-tr>
            @empty
                <x-table-sm.table-tr>
                    <x-table-sm.table-td-full-colspan>
                        Data kosong
                    </x-table-sm.table-td-full-colspan>
                </x-table-sm.table-tr>
            @endforelse


            {{-- <x-table-sm.table-tr>
                <x-table-sm.table-td colspan='9' customClass='border-0 text-left font-bold'>
                    Total
                </x-table-sm.table-td>
                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                </x-table-sm.table-td>
            </x-table-sm.table-tr> --}}

        </x-slot:row>
    </x-table-sm.table>
</div>
