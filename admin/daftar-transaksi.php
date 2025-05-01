<?php
include("koneksi.php");
?>

<div class="container mt-5 pt-5" style="background-color: whitesmoke; min-height: 100vh;">
    <div class="text-center my-4">
        <h2 class="fw-bold text-primary">Daftar Transaksi</h2>
        <p class="lead">Lihat riwayat transaksi pemesanan Anda.</p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = $koneksi->query("SELECT * FROM penjualan ORDER BY PenjualanID DESC");
                while ($data = $sql->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['IDTransaksi']; ?></td>
                        <td><?php echo $data['NamaPelanggan']; ?></td>
                        <td><?php echo $data['Tanggal']; ?></td>
                        <td>Rp.<?php echo number_format($data['TotalHarga']); ?></td>
                        <td><?php echo $data['Status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php?>
