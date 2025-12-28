<?php
include '../koneksi.php';
$nama = $_POST['nama'];
$hp = $_POST['hp'];
$alamat = $_POST['alamat'];
mysqli_query(
    $koneksi,
    "INSERT INTO pelanggan (pelanggan_nama, pelanggan_hp, pelanggan_alamat)
     VALUES ('$nama','$hp','$alamat')"
);
header("location:pelanggan.php");
?>
