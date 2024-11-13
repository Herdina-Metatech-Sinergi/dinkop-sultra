<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Piutang Anggota</title>
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
        <p style="margin-bottom: 4px; text-align: center;">Piutang Anggota</p>
        {{-- <p style="margin-top: 0px; text-align: center;">{{$periode}}</p> --}}


        <table id="dataTable" class="mt-0">
            <thead>
                <tr class="text-center">
                    <th>No Anggota</th>
                    <th>Nama</th>
                    <th>Kredit Flat Belum Lunas</th>
                    <th>Kredit Flat Lunas</th>
                    <th>Kredit Konvensional Belum Lunas</th>
                    <th>Kredit Konvensional Lunas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $data2)
                    <tr>
                        <td>{{ @$data2['no_anggota'] }}</td>
                        <td>{{ @$data2['nama'] }}</td>
                        <td>{{ App\Http\Controllers\Controller::rupiah(@$data2->porto['Kredit Flat Belum Lunas']) }}</td>
                        <td>{{ App\Http\Controllers\Controller::rupiah(@$data2->porto['Kredit Flat Lunas']) }}</td>
                        <td>{{ App\Http\Controllers\Controller::rupiah(@$data2->porto['Kredit Konvensional Belum Lunas']) }}</td>
                        <td>{{ App\Http\Controllers\Controller::rupiah(@$data2->porto['Kredit Konvensional Lunas']) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Data kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p><br><br></p>
        @include('cetak.footer')

    </div>

</body>
</html>
