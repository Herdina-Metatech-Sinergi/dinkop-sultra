<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simpanan Anggota</title>
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
        <p style="margin-bottom: 4px; text-align: center;">Simpanan Anggota</p>
        {{-- <p style="margin-top: 0px; text-align: center;">{{$periode}}</p> --}}


        <table id="dataTable" class="mt-0">
            <thead>
                <tr class="text-center">
                    <th>No Anggota</th>
                    <th>Nama</th>

                    @foreach ($menu as $men)
                    <th customClass='text-center'>
                        {{$men}}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $data2)
                    <tr>
                        <td>{{ @$data2['no_anggota'] }}</td>
                        <td>{{ @$data2['nama'] }}</td>

                        @foreach ($menu as $men)
                        <td>
                            {{ App\Http\Controllers\Controller::rupiah(@$data2->porto[$men]) }}
                        </td>
                        @endforeach
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
