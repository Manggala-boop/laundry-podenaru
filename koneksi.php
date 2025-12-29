<?php
$host = "db-laundry.mysql.database.azure.com";
$user = "sqladmin@db-laundry"; // WAJIB pakai @servername
$pass = "@Manggala77";
$db   = "laundry_podenaru";
$port = 3306;

$koneksi = mysqli_init();

/*
 ssl-mode = require
 artinya: pakai SSL, tapi tidak perlu cert file
*/
mysqli_options($koneksi, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);

$connected = mysqli_real_connect(
    $koneksi,
    $host,
    $user,
    $pass,
    $db,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$connected) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
