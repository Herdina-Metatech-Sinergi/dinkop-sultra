<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Akun Transaksi</title>
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

        {{-- <a href="{{url('accounting/laporan/akun/coa/'.$akun_coa.'/cetak?tgl_awal='.$tgl_awal.'&'.'tgl_akhir='.$tgl_akhir.'&type=excel')}}" target="__blank" class="btn btn-success btn-sm no-print">Export Excel</a> --}}
        <h3>Transaksi {{$akuntansi['coa']['title']}}</h3>
        <h4>{{$akuntansi['coa']['kode_coa']}}</h4>

        <table class="table table-bordered" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">Tanggal</th>
                    <th style="border: 1px solid black;">Jurnal</th>
                    <th style="border: 1px solid black;">Deskripsi</th>
                    <th style="border: 1px solid black;">Debet</th>
                    <th style="border: 1px solid black;">Kredit</th>
                    <th style="border: 1px solid black;">Saldo</th>
                </tr>
            </thead>
            <tbody>

                @php

                    $total = $total_lama;
                    $debet = 0;
                    $kredit = 0;

                @endphp
                @if ($total > 0)
                <tr>
                    <th colspan="3">Saldo Awal</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($total)}}</th>
                    <th style="text-align: right;border: 1px solid black;">-</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($total)}}</th>
                </tr>
                @elseif ($total < 0)
                <tr>
                    <th colspan="3">Saldo Awal</th>
                    <th style="text-align: right;border: 1px solid black;">-</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($total)}}</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($total)}}</th>
                </tr>
                @else
                <tr>
                    <th colspan="3">Saldo Awal</th>
                    <th style="text-align: right;border: 1px solid black;">-</th>
                    <th style="text-align: right;border: 1px solid black;">-</th>
                    <th style="text-align: right;border: 1px solid black;">-</th>
                </tr>
                @endif
                @foreach ($data_baru as $key2 => $t4)
                    <tr>

                        <td style="border: 1px solid black;">
                            {{$t4['tanggal']}}
                        </td>
                        <td style="border: 1px solid black;">
                            {{-- <a href="{{url('koperasi/jurnal_umum/tambah?jurnal=').\Crypt::encrypt($t4['jurnal'])}}" target="__blank">{{$t4['jurnal']}}</a> --}}
                            {{$t4['jurnal']}}
                        </td>
                        <td style="border: 1px solid black;">
                            @if ($t4['deskripsi'] == '')
                                Jurnal Manual
                            @else
                            {{$t4['deskripsi']}}

                            @endif
                        </td>

                        <td style="text-align: right;border: 1px solid black;">

                            @if ($t4['d_k'] == 'debet')
                            {{App\Http\Controllers\Controller::rupiah($t4['nominal'])}}

                            @php
                                $total +=$t4['nominal'];
                                $debet +=$t4['nominal'];
                            @endphp
                            @endif

                        </td>

                        <td style="text-align: right;border: 1px solid black;">

                            @if ($t4['d_k'] == 'kredit')
                            {{App\Http\Controllers\Controller::rupiah($t4['nominal'])}}
                            @php
                                $total -=$t4['nominal'];
                                $kredit +=$t4['nominal'];
                            @endphp
                            @endif

                        </td>
                        <td style="text-align: right;border: 1px solid black;">

                            {{App\Http\Controllers\Controller::rupiah($total)}}


                        </td>
                    </tr>

                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Saldo Akhir</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($debet)}}</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($kredit)}}</th>
                    <th style="text-align: right;border: 1px solid black;">{{App\Http\Controllers\Controller::rupiah($total)}}</th>
                </tr>
            </tfoot>

        </table>

        <p style="page-break-after: always;">&nbsp;</p>

    </div>

</body>
</html>
