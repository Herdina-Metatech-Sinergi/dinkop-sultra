<?php
// Inisialisasi variabel
$pinjamanPokok = 40000000000; // Pinjaman pokok
$jangkaWaktu = 60; // 60 bulan
$tarifLayanan = 6.0; // 6%
$angsuranPokokPertama = 666666666.67; // Angsuran pokok pertama
$angsuranPokokBerikutnya = 666666000.00; // Angsuran pokok berikutnya
$tanggalMulai = '2024-02-26'; // Tanggal pinjam

// Fungsi menghitung selisih hari antara dua tanggal
function selisihHari($start, $end) {
    $start = strtotime($start);
    $end = strtotime($end);
    return ($end - $start) / 86400;
}

// Fungsi menghitung bunga
function hitungBunga($saldo, $tarifLayanan, $jumlahHari) {
    return ($saldo * $tarifLayanan / 100) * ($jumlahHari / 360);
}

// Fungsi menghitung tanggal jatuh tempo berikutnya
function tanggalBerikutnya($tanggal, $bulanTambahan) {
    return date('Y-m-d', strtotime("+$bulanTambahan month", strtotime($tanggal)));
}

// Tentukan tanggal jatuh tempo pertama (25 April 2024)
$tanggalJatuhTempoPertama = '2024-04-25';

// Generate jadwal pembayaran
$saldo = $pinjamanPokok;
$tanggalSekarang = $tanggalJatuhTempoPertama;

$dataAngsuran = []; // Array untuk menyimpan data angsuran

// Angsuran ke-0 (tidak ada pembayaran)
$dataAngsuran[] = [
    'angsuran_ke' => 0,
    'tanggal_jatuh_tempo' => '25/03/2024',
    'jumlah_hari' => 0,
    'pokok' => number_format($saldo, 2, ',', '.'),
    'jumlah_angsuran' => '0,00',
    'angsuran_pokok' => '-',
    'angsuran_bunga' => '0,00',
    'baki_debet' => number_format($saldo, 2, ',', '.'),
];

// Angsuran pertama (jumlah hari = 59 hari)
$jumlahHari = selisihHari($tanggalMulai, $tanggalSekarang);
$bunga = hitungBunga($saldo, $tarifLayanan, $jumlahHari);
$jumlahAngsuran = $angsuranPokokPertama + $bunga;

$dataAngsuran[] = [
    'angsuran_ke' => 1,
    'tanggal_jatuh_tempo' => date('d/m/Y', strtotime($tanggalSekarang)),
    'jumlah_hari' => $jumlahHari,
    'pokok' => number_format($saldo, 2, ',', '.'),
    'jumlah_angsuran' => number_format($jumlahAngsuran, 2, ',', '.'),
    'angsuran_pokok' => number_format($angsuranPokokPertama, 2, ',', '.'),
    'angsuran_bunga' => number_format($bunga, 2, ',', '.'),
    'baki_debet' => number_format($saldo - $angsuranPokokPertama, 2, ',', '.'),
];

// Loop untuk menghasilkan jadwal pembayaran selanjutnya
$saldo -= $angsuranPokokPertama;

for ($i = 2; $i <= $jangkaWaktu; $i++) {
    $tanggalSebelumnya = $tanggalSekarang;
    $tanggalSekarang = tanggalBerikutnya($tanggalSekarang, 1);
    $jumlahHari = selisihHari($tanggalSebelumnya, $tanggalSekarang);

    // Pada periode terakhir, angsuran pokok harus disesuaikan agar saldo menjadi 0
    if ($i == $jangkaWaktu) {
        $angsuranPokok = $saldo; // Sisa saldo ditutup di periode terakhir
    } else {
        $angsuranPokok = $angsuranPokokBerikutnya;
    }

    $bunga = hitungBunga($saldo, $tarifLayanan, $jumlahHari);
    $jumlahAngsuran = $angsuranPokok + $bunga;

    $dataAngsuran[] = [
        'angsuran_ke' => $i,
        'tanggal_jatuh_tempo' => date('d/m/Y', strtotime($tanggalSekarang)),
        'jumlah_hari' => $jumlahHari,
        'pokok' => number_format($saldo, 2, ',', '.'),
        'jumlah_angsuran' => number_format($jumlahAngsuran, 2, ',', '.'),
        'angsuran_pokok' => number_format($angsuranPokok, 2, ',', '.'),
        'angsuran_bunga' => number_format($bunga, 2, ',', '.'),
        'baki_debet' => number_format($saldo - $angsuranPokok, 2, ',', '.'),
    ];

    $saldo -= $angsuranPokok;
}
var_dump($dataAngsuran[count($dataAngsuran) - 1]);
die();
// Anda sekarang memiliki array $dataAngsuran yang bisa digunakan
// Untuk menampilkan tabel, Anda bisa menggunakan loop berikut
echo "<table border='1'>";
echo "<tr>
        <th>Angsuran ke</th>
        <th>Tanggal Jatuh Tempo</th>
        <th>Jumlah Hari</th>
        <th>Pokok (Rp)</th>
        <th>Jumlah Angsuran (Rp)</th>
        <th>Angsuran Pokok</th>
        <th>Angsuran Bunga</th>
        <th>Baki Debet</th>
      </tr>";

foreach ($dataAngsuran as $angsuran) {
    echo "<tr>
            <td>{$angsuran['angsuran_ke']}</td>
            <td>{$angsuran['tanggal_jatuh_tempo']}</td>
            <td>{$angsuran['jumlah_hari']}</td>
            <td>{$angsuran['pokok']}</td>
            <td>{$angsuran['jumlah_angsuran']}</td>
            <td>{$angsuran['angsuran_pokok']}</td>
            <td>{$angsuran['angsuran_bunga']}</td>
            <td>{$angsuran['baki_debet']}</td>
          </tr>";
}

echo "</table>";
?>
