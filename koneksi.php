<?php
$host = "db-laundry.mysql.database.azure.com";
$user = "sqladmin@db-laundry";
$pass = "@Manggala77";
$db   = "laundry_podenaru";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
