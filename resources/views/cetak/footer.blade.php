<table class='table borderless'>
    <tr>

        <td style="text-align: right">
            <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['kabupaten_kota'] ?? 'Lengkapi Kota dahulu'}}, {{date('d-m-Y')}}</p>
        </td>
    </tr>
    <tr>

        <td style="text-align: center">
            <p style="margin-bottom: 0px; font-size: 14px;">Pengurus</p>
        </td>
    </tr>

</table>

<table class='table borderless'>

    <tr>

        <td style="text-align: left">
            <p style="margin-bottom: 0px; font-size: 14px;">Ketua</p>
            <p><br><br><br><br></p>
            <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['nama_pengurus'] ?? "Lengkapi Nama Pengurus"}}</p>
        </td>

        <td style="text-align: center">
            <p style="margin-bottom: 0px; font-size: 14px;">Sekretaris</p>
            <p><br><br><br><br></p>
            <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['nama_sekretaris'] ?? "Lengkapi Nama Sekretaris"}}</p>
        </td>

        <td style="text-align: right">
            <p style="margin-bottom: 0px; font-size: 14px;">Bendahara</p>
            <p><br><br><br><br></p>
            <p style="margin-bottom: 0px; font-size: 14px;">{{$identitas['nama_bendahara'] ?? "Lengkapi Nama Bendahara"}}</p>
        </td>
    </tr>
</table>
