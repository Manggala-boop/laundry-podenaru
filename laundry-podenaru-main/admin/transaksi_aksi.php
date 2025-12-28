<?php
include '../koneksi.php';

$pelanggan    = $_POST['pelanggan'];
$berat        = $_POST['berat'];
$tgl_selesai  = $_POST['tgl_selesai'];
$tgl_hari_ini = date('Y-m-d');
$status       = 0;

/* ambil harga */
$h = mysqli_query($koneksi, "SELECT harga_per_kilo FROM harga");
$harga_per_kilo = mysqli_fetch_assoc($h);
$harga = $berat * $harga_per_kilo['harga_per_kilo'];

/* insert transaksi */
$q_transaksi = mysqli_query(
    $koneksi,
    "INSERT INTO transaksi 
    (transaksi_tgl, transaksi_pelanggan, transaksi_harga, transaksi_berat, transaksi_tgl_selesai, transaksi_status)
    VALUES 
    ('$tgl_hari_ini','$pelanggan','$harga','$berat','$tgl_selesai','$status')"
);

if (!$q_transaksi) {
    die(mysqli_error($koneksi));
}

$id_terakhir = mysqli_insert_id($koneksi);

/* insert pakaian */
$jenis_pakaian  = $_POST['jenis_pakaian'];
$jumlah_pakaian = $_POST['jumlah_pakaian'];

for ($x = 0; $x < count($jenis_pakaian); $x++) {
    if ($jenis_pakaian[$x] != "") {
        $q_pakaian = mysqli_query(
            $koneksi,
            "INSERT INTO pakaian 
            (pakaian_transaksi, pakaian_jenis, pakaian_jumlah)
            VALUES 
            ('$id_terakhir','$jenis_pakaian[$x]','$jumlah_pakaian[$x]')"
        );

        if (!$q_pakaian) {
            die(mysqli_error($koneksi));
        }
    }
}

header("Location: transaksi.php");
exit;
