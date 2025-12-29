<?php
include '../koneksi.php';
include '../wa/fonnte.php';

$id          = $_POST['id'];
$pelanggan   = $_POST['pelanggan'];
$berat       = $_POST['berat'];
$tgl_selesai = $_POST['tgl_selesai'];
$status      = $_POST['status'];

/* hitung harga */
$h = mysqli_query($koneksi, "SELECT harga_per_kilo FROM harga");
$harga_per_kilo = mysqli_fetch_assoc($h);
$harga = $berat * $harga_per_kilo['harga_per_kilo'];

/* update transaksi */
$q_update = mysqli_query(
    $koneksi,
    "UPDATE transaksi SET
        transaksi_pelanggan    = '$pelanggan',
        transaksi_harga        = '$harga',
        transaksi_berat        = '$berat',
        transaksi_tgl_selesai  = '$tgl_selesai',
        transaksi_status       = '$status'
     WHERE transaksi_id = '$id'"
);

if (!$q_update) {
    die(mysqli_error($koneksi));
}

/* hapus pakaian lama */
mysqli_query(
    $koneksi,
    "DELETE FROM pakaian WHERE pakaian_transaksi='$id'"
);

/* insert ulang pakaian */
$jenis_pakaian  = $_POST['jenis_pakaian'];
$jumlah_pakaian = $_POST['jumlah_pakaian'];

for ($x = 0; $x < count($jenis_pakaian); $x++) {
    if ($jenis_pakaian[$x] != "") {
        mysqli_query(
            $koneksi,
            "INSERT INTO pakaian (pakaian_transaksi, pakaian_jenis, pakaian_jumlah)
             VALUES ('$id', '{$jenis_pakaian[$x]}', '{$jumlah_pakaian[$x]}')"
        );
    }
}

/* KIRIM WA JIKA STATUS = SELESAI */
if ($status == 2) {

    $q = mysqli_query(
        $koneksi,
        "SELECT pelanggan_hp, pelanggan_nama
         FROM transaksi
         JOIN pelanggan ON transaksi_pelanggan = pelanggan_id
         WHERE transaksi_id = '$id'"
    );

    $d = mysqli_fetch_assoc($q);

    if ($d) {
        // normalisasi nomor HP
        $hp = preg_replace('/[^0-9]/', '', $d['pelanggan_hp']);
        if (substr($hp, 0, 1) == '0') {
            $hp = '62' . substr($hp, 1);
        }

        $pesan = "Halo {$d['pelanggan_nama']},
Laundry Anda telah *SELESAI*.

Invoice: INVOICE-$id
Silakan diambil di PODENARU LAUNDRY.
Terima kasih.";

        kirim_wa($hp, $pesan);
    }
}

header("Location: transaksi.php");
exit;
