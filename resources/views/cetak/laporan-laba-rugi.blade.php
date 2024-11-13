<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHU</title>
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
        table {
  width: 100%;
  border-collapse: collapse;
  font-size: 10px;

}
        table, th, td {
  /* border: 1px solid; */
  padding: 4px;
}

    </style>
</head>
<body>

    <div class="container">
        @include('cetak.header')

        <hr>
        <p style="margin-bottom: 4px; text-align: center;">Laporan PHU</p>
        {{-- <p style="margin-top: 0px; text-align: center;">{{$periode}}</p> --}}


        <table class="table table-bordered" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">Keterangan</th>
                    <th style="border: 1px solid black;">{{$tgl_awal}} s/d {{$tgl_akhir}}<br></th>
                    <th style="border: 1px solid black;">Sd Bulan Ini <br></th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>Pendapatan</b>
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>
                </tr>
                @foreach ($akuntansi['laporan_shu'][4] as $key => $item)
                @if ($item['nominal'] != 0)
                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;&nbsp;&nbsp;-{{$item['data']['title']}} ({{$item['data']['kode_coa']}})
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['laporan_shu_rentang'][4][$key]['nominal']) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                    </td>

                </tr>
                @endif
                @endforeach


                @foreach ($akuntansi['laporan_shu'][7] ?? [] as $key => $item)
                @if ($item['nominal'] != 0)
                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;&nbsp;&nbsp;-{{$item['data']['title']}} ({{$item['data']['kode_coa']}})
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['laporan_shu_rentang'][7][$key]['nominal']) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                    </td>

                </tr>
                @endif
                @endforeach

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;" >
                        &nbsp;&nbsp;&nbsp;<b>Total Pendapatan</b>
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu_rentang'][4] + $akuntansi['total_laporan_shu_rentang'][7]) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu'][4] + $akuntansi['total_laporan_shu'][7]) }}
                    </td>

                </tr>




                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>Beban</b>
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>
                </tr>
                @foreach ($akuntansi['laporan_shu'][5] as $key => $item)
                @if ($item['nominal'] != 0)
                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;&nbsp;&nbsp;-{{$item['data']['title']}} ({{$item['data']['kode_coa']}})
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['laporan_shu_rentang'][5][$key]['nominal']) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                    </td>

                </tr>
                @endif
                @endforeach


                <tr>
                    <td style="text-align: left;border-right: 1px solid black;" >
                        &nbsp;&nbsp;&nbsp;<b>Total Beban</b>
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu_rentang'][5]) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu'][5]) }}
                    </td>

                </tr>

                <tr style="background-color: gray; color: white">
                    <td style="text-align: left;border-right: 1px solid black; ">
                        <b>SHU KOTOR</b>
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah(($akuntansi['total_laporan_shu_rentang'][4] + $akuntansi['total_laporan_shu_rentang'][7]) - $akuntansi['total_laporan_shu_rentang'][5]) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah(($akuntansi['total_laporan_shu'][4] + $akuntansi['total_laporan_shu'][7]) - $akuntansi['total_laporan_shu'][5]) }}
                    </td>
                </tr>


                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>Biaya</b>
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>

                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>
                </tr>
                @foreach ($akuntansi['laporan_shu'][6] as $key => $item)
                @if ($item['nominal'] != 0)
                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;&nbsp;&nbsp;-{{$item['data']['title']}} ({{$item['data']['kode_coa']}})
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['laporan_shu_rentang'][6][$key]['nominal']) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                    </td>

                </tr>
                @endif
                @endforeach


                <tr>
                    <td style="text-align: left;border-right: 1px solid black;" >
                        &nbsp;&nbsp;&nbsp;<b>Total Biaya</b>
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu_rentang'][6]) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['total_laporan_shu'][6]) }}
                    </td>

                </tr>

                <tr style="background-color: gray; color: white">
                    <td style="text-align: left;border-right: 1px solid black; ">
                        <b>SHU BERSIH</b>
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah(($akuntansi['total_laporan_shu_rentang'][4] + $akuntansi['total_laporan_shu_rentang'][7]) - $akuntansi['total_laporan_shu_rentang'][5] - $akuntansi['total_laporan_shu_rentang'][6]) }}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah(($akuntansi['total_laporan_shu'][4] + $akuntansi['total_laporan_shu'][7]) - $akuntansi['total_laporan_shu'][5] - $akuntansi['total_laporan_shu'][6]) }}
                    </td>
                </tr>
            </tbody>

        </table>

        <p><br><br></p>
        @include('cetak.footer')

    </div>

</body>
</html>
