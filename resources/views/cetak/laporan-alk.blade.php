<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Analisa Laporan Keuangan</title>
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
        @include('cetak.header')

        <hr>
        <p style="margin-bottom: 0px; font-size: 16px;text-align: center">Laporan Analisa Laporan Keuangan</p>
        <p style="margin-top: 0px; font-size: 16px;text-align: center">{{$tgl_awal}} s/d {{$tgl_akhir}}</p>

        <table class="table" style="border: 1px solid black;padding-bottom: 0px;">

            <tr>
                <td style="border: 1px solid; vertical-align: 0; width: 50%">
                    <table class="table">
                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'LIKUIDITAS')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                (Aktiva Lancar / Hutang Lancar) * 100%
                            </td>
                            <td style="text-align: right">

                                @php
                                $hasil = 0;
                                    try {
                                        //code...
                                        $hasil = $akuntansi['total_laporan_shu']['aset_lancar'] / $akuntansi['total_laporan_shu']['hutang_lancar'] * 100;
                                    } catch (\Throwable $th) {
                                        //throw $th;
                                    }
                                @endphp
                                {{ App\Http\Controllers\Controller::rupiah($hasil) }} %

                            </td>

                        </tr>
                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'SOLVABILITAS')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                (Aktiva / Hutang) * 100%
                            </td>
                            <td style="text-align: right">

                                @php
                                $hasil = 0;
                                    try {
                                        //code...
                                        $hasil = $akuntansi['final_total']['aset'] / ($akuntansi['total_laporan_shu']['hutang_lancar'] + $akuntansi['total_laporan_shu']['hutang_jangka_panjang']) * 100;
                                    } catch (\Throwable $th) {
                                        //throw $th;
                                    }
                                @endphp
                                {{ App\Http\Controllers\Controller::rupiah($hasil) }} %

                            </td>

                        </tr>

                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'RENTABILITAS')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                (SHU Tahun Berjalan / Modal) * 100%
                            </td>
                            <td style="text-align: right">

                                @php
                                $hasil = 0;
                                    try {
                                        //code...
                                        $hasil = $akuntansi['total_laporan_shu']['shu']  / ($akuntansi['total_laporan_shu']['modal'] - ($total_nominal_tahun_sekarang ?? 0)) * 100;
                                    } catch (\Throwable $th) {
                                    }
                                @endphp
                                {{ App\Http\Controllers\Controller::rupiah($hasil) }} %

                            </td>

                        </tr>

                    </table>
                </td>



            </tr>

        </table>

        <p><br><br></p>
        @include('cetak.footer')

    </div>

</body>

</html>
