<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Arus Kas</title>
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
        <p style="margin-bottom: 0px; font-size: 16px;text-align: center">Laporan Arus Kas</p>
        <p style="margin-top: 0px; font-size: 16px;text-align: center">{{$tgl_awal}} s/d {{$tgl_akhir}}</p>

        <table class="table" style="border: 1px solid black;padding-bottom: 0px;">

            <tr>
                <td style="border: 1px solid; vertical-align: 0; width: 50%">
                    <table class="table">

                        <tr>
                            <td>

                                <b>{{ ucwords(str_replace('_', ' ', 'SHU Tahun Berjalan')) }}</b>
                            </td>
                            <td style="text-align: right">

                                &nbsp;

                            </td>

                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                SHU Tahun Berjalan
                            </td>
                            <td style="text-align: right">

                                @php
                                $hasil = 0;
                                    try {
                                        //code...
                                        $hasil = $akuntansi['total_laporan_shu']['shu'] ;
                                    } catch (\Throwable $th) {
                                    }
                                @endphp
                                {{ App\Http\Controllers\Controller::rupiah($hasil) }}

                            </td>

                        </tr>

                        <h4>1. Arus Kas dari Aktivitas Operasional</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kelompok</th>
                <th>Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($operasional as $flow)
                <tr>
                    <td>{{ $flow['kode_coa'] }}</td>
                    <td>{{ $flow['title'] }}</td>
                    <td>{{ $flow['kelompok'] }}</td>
                    <td>{{ number_format($flow['nominal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>2. Arus Kas dari Aktivitas Investasi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kelompok</th>
                <th>Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investasi as $flow)
                <tr>
                    <td>{{ $flow['kode_coa'] }}</td>
                    <td>{{ $flow['title'] }}</td>
                    <td>{{ $flow['kelompok'] }}</td>
                    <td>{{ number_format($flow['nominal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>3. Arus Kas dari Aktivitas Pendanaan</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kelompok</th>
                <th>Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendanaan as $flow)
                <tr>
                    <td>{{ $flow['kode_coa'] }}</td>
                    <td>{{ $flow['title'] }}</td>
                    <td>{{ $flow['kelompok'] }}</td>
                    <td>{{ number_format($flow['nominal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    </table>
                </td>



            </tr>

        </table>

        <p><br><br></p>
        @include('cetak.footer')

    </div>

</body>

</html>
