<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan CALK</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;

        }

        table,
        th,
        td {
            /* border: 1px solid; */
            padding: 4px;
        }
    </style>
</head>

<body>


    <div class="container">
        <table class='table borderless'>
            <tr>

                <td style="text-align: center">
                    <p style="margin-bottom: 0px; font-size: 18px;">{{$identitas['nama_koperasi']}}</p>
                    <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['alamat']}}</p>
                    <p style="margin-bottom: 0px; font-size: 14px;">Telepon {{$identitas['telp_fax_email']}}</p>
                </td>
            </tr>
        </table>
        <hr>
        <p style="margin-bottom: 0px; font-size: 16px;text-align: center">Laporan CALK</p>
        <p style="margin-top: 0px; font-size: 16px;text-align: center">{{$tgl_awal}} s/d {{$tgl_akhir}}</p>

        <p><br></p>
        {!! $calk !!}
        <p><br></p>
        <table class="table" style="border: 1px solid black;padding-bottom: 0px;">

            <tr>
                <td style="border: 1px solid; vertical-align: 0; width: 50%">
                    <table class="table">
                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'aset_lancar')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['aset_lancar'] as $key => $item)
                            @if ($item['nominal'] != 0)
                                <tr>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ @$item['data']['title'] }}
                                    </td>
                                    <td style="text-align: right">

                                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['aset_lancar']) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>


                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'aset_tidak_lancar')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['aset_tidak_lancar'] ?? [] as $key => $item)
                            @if ($item['nominal'] != 0)
                                <tr>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ @$item['data']['title'] }}
                                    </td>
                                    <td style="text-align: right">

                                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['aset_tidak_lancar'] ?? 0) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>

                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'aset_tetap')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['aset_tetap'] ?? [] as $key => $item)
                            @if ($item['nominal'] != 0)
                                <tr>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ @$item['data']['title'] }}
                                    </td>
                                    <td style="text-align: right">

                                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['aset_tetap'] ?? 0) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>

                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'aset_lainnya')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['aset_lainnya'] ?? [] as $key => $item)
                            @if ($item['nominal'] != 0)
                                <tr>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ @$item['data']['title'] }}
                                    </td>
                                    <td style="text-align: right">

                                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['aset_lainnya'] ?? 0) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>
                    </table>
                </td>



            </tr>

            <tr>
                <td style="border: 1px solid; vertical-align: 0; width: 50%">
                    <table class="table">

                        <tr>
                            <td>
                                <b>T O T A L</b>
                            </td>
                            <td style="text-align: right; font-weight: bold">
                                {{ App\Http\Controllers\Controller::rupiah(@$akuntansi['final_total']['aset']) }}

                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="border: 1px solid; vertical-align: 0; width: 50%">
                    <table class="table">
                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'hutang_lancar')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['hutang_lancar'] as $key => $item)
                            @if ($item['nominal'] != 0)
                                <tr>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ @$item['data']['title'] }}
                                    </td>
                                    <td style="text-align: right">

                                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['hutang_lancar']) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>


                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'hutang_jangka_panjang')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['hutang_jangka_panjang'] ?? [] as $key => $item)
                            @if ($item['nominal'] != 0)
                                <tr>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ @$item['data']['title'] }}
                                    </td>
                                    <td style="text-align: right">

                                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['hutang_jangka_panjang'] ?? 0) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>


                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'modal')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @php
                            use Carbon\Carbon;
                            use App\Models\JurnalUmum;

                            // Mendapatkan tahun sekarang
                            // $currentYear = $tahun;

                            // Mendapatkan tanggal awal dan akhir untuk tahun sekarang
                            $tahun_sekarang = date('Y');
                            $tgl_awal_tahun_sekarang = $tahun_sekarang . '-01-01';
                            $tgl_akhir_tahun_sekarang = $tgl_akhir;

                            // Mendapatkan jurnal untuk tahun sekarang
                            $jurnal_tahun_sekarang = JurnalUmum::whereHas('coa', function($query) {
                                $query->where('title', 'like', '%SHU Dibagikan%');
                            })
                            ->whereBetween('tanggal', [$tgl_awal_tahun_sekarang, $tgl_akhir_tahun_sekarang])
                            ->with(['coa'])
                            ->get();

                            // Mendapatkan jurnal untuk semua tahun sebelum tahun sekarang
                            $jurnal_tahun_sebelumnya = JurnalUmum::whereHas('coa', function($query) {
                                $query->where('title', 'like', '%SHU%');
                            })
                            ->where('tanggal', '<', $tgl_awal_tahun_sekarang) // Mengambil jurnal sebelum tahun sekarang
                            ->with(['coa'])
                            ->get();


                            // Menghitung total nominal untuk tahun sekarang
                            $total_nominal_tahun_sekarang = $jurnal_tahun_sekarang->sum('nominal');

                            // Menghitung total nominal untuk tahun sebelumnya
                            $total_nominal_tahun_sebelumnya = $jurnal_tahun_sebelumnya->sum('nominal');

                            // dd($total_nominal_tahun_sebelumnya,$total_nominal_tahun_sekarang);



                        @endphp
                        @foreach ($akuntansi['laporan_shu']['modal'] ?? [] as $key => $item)
                            @if ($item['nominal'] != 0)
                            @if (!str_contains(@$item['data']['title'],'SHU'))

                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ @$item['data']['title'] }}
                                </td>
                                <td style="text-align: right">

                                    {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                                </td>

                            </tr>
                            @endif

                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['modal'] - $total_nominal_tahun_sekarang ?? 0) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>


                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'shu')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        @foreach ($akuntansi['laporan_shu']['shu'] ?? [] as $key => $item)
                        {{-- {{dd($akuntansi['laporan_shu']['shu'])}} --}}
                            @if ($item['nominal'] != 0)
                            @if ($key == 0)
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ @$item['data']['title'] ?? 'SHU Tahun Lalu' }}
                                </td>
                                <td style="text-align: right">

                                    {{ App\Http\Controllers\Controller::rupiah($item['nominal'] - $total_nominal_tahun_sebelumnya) }}

                                </td>

                            </tr>
                            @else
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ @$item['data']['title'] ?? 'SHU Tahun Berjalan' }}
                                </td>
                                <td style="text-align: right">

                                    {{ App\Http\Controllers\Controller::rupiah($item['nominal'] - $total_nominal_tahun_sekarang) }}

                                </td>

                            </tr>
                            @endif

                            @endif
                        @endforeach
                        <tr>
                            <td>

                            </td>
                            <td style="text-align: right; border-top: 1px solid; border-bottom: 1px solid;">



                                {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu']['shu'] - ($total_nominal_tahun_sekarang + $total_nominal_tahun_sebelumnya) ?? 0) }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                            </td>

                        </tr>
                    </table>
                </td>


            </tr>

            <tr>
                <td style="border: 1px solid; vertical-align: 0; width: 50%">
                    <table class="table">

                        <tr>
                            <td>
                                <b>T O T A L</b>
                            </td>
                            <td style="text-align: right; font-weight: bold">

                                {{ App\Http\Controllers\Controller::rupiah(@$akuntansi['total_laporan_shu']['hutang_lancar'] + @$akuntansi['total_laporan_shu']['hutang_jangka_panjang'] + ($akuntansi['total_laporan_shu']['modal'] - $total_nominal_tahun_sekarang) + ($akuntansi['total_laporan_shu']['shu'] - ($total_nominal_tahun_sekarang + $total_nominal_tahun_sebelumnya)) ) }}

                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p><br><br></p>
        <table class='table borderless'>
            <tr>

                <td style="text-align: right">
                    <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['kabupaten_kota']}}, {{date('d-m-Y')}}</p>
                    <p style="margin-bottom: 0px; font-size: 14px;">Pengurus</p>
                    <p><br><br><br></p>
                    <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['nama_pengurus']}}</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
