<!DOCTYPE html>
<html>
<head>
    <title>Cek Status Laundry</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body style="background:#f5f6fa">

<div class="container" style="margin-top:50px; max-width:800px">

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h4>Cek Status Pesanan Laundry</h4>
        </div>

        <div class="panel-body">

            <form method="post" class="form-inline text-center">
                <div class="form-group">
                    <input type="text" name="hp" class="form-control"
                           placeholder="Masukkan Nomor HP"
                           required>
                </div>
                <button type="submit" class="btn btn-primary">
                    Cek Status
                </button>
            </form>

            <hr>

            <?php
            if (isset($_POST['hp'])) {
                include '../koneksi.php';

                $hp = mysqli_real_escape_string($koneksi, $_POST['hp']);

                $data = mysqli_query(
                    $koneksi,
                    "SELECT *
                     FROM transaksi
                     JOIN pelanggan ON transaksi_pelanggan = pelanggan_id
                     WHERE pelanggan_hp='$hp'
                     ORDER BY transaksi_id DESC"
                );

                if (mysqli_num_rows($data) == 0) {
                    echo "<div class='alert alert-warning text-center'>
                            Data tidak ditemukan
                          </div>";
                } else {
            ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Berat</th>
                        <th>Harga</th>
                    </tr>

                    <?php while ($d = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td>INVOICE-<?php echo $d['transaksi_id']; ?></td>
                        <td><?php echo $d['transaksi_tgl']; ?></td>
                        <td>
                            <?php
                            if ($d['transaksi_status'] == 0) {
                                echo "<span class='label label-warning'>PROSES</span>";
                            } elseif ($d['transaksi_status'] == 1) {
                                echo "<span class='label label-info'>DICUCI</span>";
                            } else {
                                echo "<span class='label label-success'>SELESAI</span>";
                            }
                            ?>
                        </td>
                        <td><?php echo $d['transaksi_berat']; ?> Kg</td>
                        <td>Rp <?php echo number_format($d['transaksi_harga']); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>

            <?php
                }
            }
            ?>

        </div>
    </div>

    <div class="text-center">
        <a href="../index.php">Kembali ke Beranda</a>
    </div>

</div>

</body>
</html>
