<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perubahan Modal</title>
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
        <p style="margin-bottom: 4px; text-align: center;">Laporan Perubahan Modal</p>
        {{-- <p style="margin-top: 0px; text-align: center;">{{$periode}}</p> --}}


        <table class="table table-bordered" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">Keterangan</th>
                    <th style="border: 1px solid black;">{{$tgl_awal}} s/d {{$tgl_akhir}}<br></th>
                </tr>
            </thead>
            @php
                $total = 0;
            @endphp
            <tbody>

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>I Saldo Ekuitas Awal</b>
                    </td>
                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['perhitungan_lama']['total']) }}
                        @php
                            $total += $akuntansi['perhitungan_lama']['total'];
                        @endphp
                    </td>

                </tr>

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>II Ditambah</b>
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>

                </tr>
                @foreach ($akuntansi['perhitungan_new']['laporan_shu_group_new']['debet'] ?? [] as $key => $item)
                @if ($item['nominal'] != 0)
                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;&nbsp;&nbsp;-{{$item['data']['title']}}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                    </td>

                    @php
                        $total +=$item['nominal'];
                    @endphp

                </tr>
                @endif
                @endforeach

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>Jumlah (I + II)</b>
                    </td>
                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['perhitungan_lama']['total'] + $akuntansi['perhitungan_new']['total_debet_new']) }}
                    </td>

                </tr>

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>III Dikurangi</b>
                    </td>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;
                    </td>

                </tr>
                @foreach ($akuntansi['perhitungan_new']['laporan_shu_group_new']['kredit'] ?? [] as $key => $item)
                @if ($item['nominal'] != 0)
                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        &nbsp;&nbsp;&nbsp;-{{$item['data']['title']}}
                    </td>

                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                    </td>

                    @php
                        $total -=$item['nominal'];
                    @endphp

                </tr>
                @endif
                @endforeach

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>Jumlah (III)</b>
                    </td>
                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($akuntansi['perhitungan_new']['total_kredit_new']) }}
                    </td>

                </tr>

                <tr>
                    <td style="text-align: left;border-right: 1px solid black;">
                        <b>Jumlah (I+II) - III</b>
                    </td>
                    <td style="text-align: right;border-right: 1px solid black;">
                        {{ App\Http\Controllers\Controller::rupiah($total) }}
                    </td>

                </tr>
            </tbody>

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
