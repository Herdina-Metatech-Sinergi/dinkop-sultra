<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jurnal Umum</title>
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
            padding: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class='table borderless'>
            <tr>
                @php
                $jrn;
                    foreach ($jurnal as $key => $value) {
                        # code...
                        $jrn = $value[0];
                        break;
                    }
                @endphp

                <td style="text-align: center">
                    <p style="margin-bottom: 0px; font-size: 18px;">{{@$jrn['identitas_koperasi']['nama_koperasi']}}</p>
                    <p style="margin-bottom: 0px; font-size: 14px;">{{@$jrn['identitas_koperasi']['alamat']}}</p>
                    <p style="margin-bottom: 0px; font-size: 14px;">Telepon {{@$jrn['identitas_koperasi']['telp_fax_email']}}</p>
                </td>
            </tr>
        </table>
        <hr>
        <h3 style="text-align: center">Jurnal Umum</h3>
        <h3 style="text-align: center">Periode : {{ $periode }}</h3>

        <div class="table-responsive">
            <table class="table" style="border: 1px solid;">
                <thead>
                    <tr>
                        <th colspan="2" style="border: 1px solid;">Tanggal</th>
                        <th style="border: 1px solid;">Keterangan</th>
                        <th style="border: 1px solid;">Kode Akun</th>
                        <th style="border: 1px solid;">Jurnal</th>
                        <th style="border: 1px solid;">Debet</th>
                        <th style="border: 1px solid;">Kredit</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $debit = 0;
                        $kredit = 0;
                        $no = 1;
                        // dd($jurnal);
                    @endphp
                    @foreach ($jurnal as $key => $jur)
                        {{-- {{dd($item)}} --}}
                        @foreach ($jur as $key2 => $item)
                        @if ($item['d_k'] == 'debet')
                        <tr>
                            <td style="vertical-align: top;  border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ date('d-M-Y', strtotime($item['tanggal'])) }}</td>


                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">{{ $no++ }}</td>
                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ @$item['coa']['title'] }}
                                @if (@$item['deskripsi'])
                                    {{-- <br>
                                    ({{ @$item['deskripsi'] }}) --}}
                                @else
                                    &nbsp;
                                @endif

                            </td>
                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ @$item['akun'] }}
                            </td>

                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ $item['jurnal'] }}
                            </td>
                            <td style="text-align: right;vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}

                            </td>
                            <td style="text-align: right;vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">

                            </td>
                        </tr>
                        @php
                            $debit += $item['nominal'];
                        @endphp
                    @else
                        <tr>
                            <td style="vertical-align: top;  border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ date('d-M-Y', strtotime($item['tanggal'])) }}</td>


                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">{{ $no++ }}</td>
                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ @$item['coa']['title'] }}
                                @if (@$item['deskripsi'])
                                    {{-- <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;({{ @$item['deskripsi'] }}) --}}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ @$item['akun'] }}
                            </td>

                            <td style="vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">
                                {{ $item['jurnal'] }}
                            </td>
                            <td style="text-align: right;vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">

                            </td>
                            <td style="text-align: right;vertical-align: top;border-right: 1px solid; {{($key2 == 0) ? 'border-top: 1px solid;' : ''}}">

                                {{ App\Http\Controllers\Controller::rupiah($item['nominal']) }}
                            </td>
                        </tr>
                        @php
                            $kredit += $item['nominal'];
                        @endphp
                    @endif
                        @endforeach
                    @endforeach
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: center;  border: 1px solid;
                            ">
                            Saldo</td>
                        <td style="text-align: right;  border: 1px solid;
                            ">
                            {{ App\Http\Controllers\Controller::rupiah($debit) }}
                        </td>
                        <td style="text-align: right;  border: 1px solid;
                            ">
                            {{ App\Http\Controllers\Controller::rupiah($kredit) }}
                        </td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
