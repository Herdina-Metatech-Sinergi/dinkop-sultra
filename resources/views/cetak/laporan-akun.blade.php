<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Akun</title>
    <link rel="stylesheet" href="{{public_path('css/bootstrap.min.css')}}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
@media print
{
    .no-print, .no-print *
    {
        display: none !important;
    }
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
    </div>

    <div class="container">

        {{-- <a href="{{url('accounting/laporan/akun/cetak'.'?tgl_awal='.$tgl_awal.'&'.'tgl_akhir='.$tgl_akhir.'&type=excel')}}" target="__blank" class="btn btn-success btn-sm no-print">Export Excel</a> --}}

        <table class="table table-bordered" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">Kode</th>
                    <th style="border: 1px solid black;">Nama</th>
                    <th style="border: 1px solid black;">Kelompok</th>
                    <th style="border: 1px solid black;">Saldo</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($akuntansi as $key2 => $t4)
                    <tr>

                        <td style="border: 1px solid black;">
                            <a href="{{url('admin/cetak/laporan-akun/coa/').'/'.$t4['kode_coa'].'/cetak?'.$query}}" target="__blank">{{$t4['kode_coa']}}</a>
                        </td>
                        <td style="border: 1px solid black;">
                            {{$t4['title']}}
                        </td>
                        <td style="border: 1px solid black;">
                            {{$t4['kelompok']}}
                        </td>

                        <td style="text-align: right;border: 1px solid black;">

                            {{App\Http\Controllers\Controller::rupiah($t4['nominal'])}}

                        </td>
                    </tr>

                @endforeach

            </tbody>

        </table>

        <p style="page-break-after: always;">&nbsp;</p>

    </div>

</body>
</html>
