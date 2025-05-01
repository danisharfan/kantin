<?php
include("header.php");
include("admin/koneksi.php");
?>
<nav style="background-color: #4863A0;" class="navbar navbar-expand-sm navbar-secondary fixed-top">
        <div class="container-fluid">
            <a href="#" class="navbar-brand text-light">Waroenk</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-light mx-2">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="pilih-menu.php" class="nav-link text-light mx-2">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="pesan-menu.php" class="nav-link text-light mx-2">Pesan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="p-4">
    <div class="card mt-5">
        <div class="card-body">
            <a href="edit-menu.php" style="background-color: #4863A0;" class="btn btn-md text-light btn-outline-dark float-end mb-3">Tambah Pesanan</a>
            <p class="float-end me-3">Berubah pikiran dan ingin menambah pesanan?</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Nama Pemesan</th>
                        <th>No Hp</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalharga = 0;
                        $sql = $koneksi->query("SELECT * FROM penjualan ORDER BY PenjualanID DESC");
                        $data = $sql->fetch_assoc()
                    ?>
                    <tr>
                        <td><?php echo $data['PenjualanID'] ?></td>
                        <td><?php echo $data['TanggalPenjualan'] ?></td>
                    <?php
                        $sql2 = $koneksi->query("SELECT * FROM pelanggan WHERE PelangganID='".$data['PenjualanID']."' ");
                        while($data2 = $sql2->fetch_assoc()) { ?>
                        <td><?php echo $data2['NamaPelanggan'] ?></td>
                        <td><?php echo $data2['NomerTelepon'] ?></td>
                    <?php } ?>
                        <td>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <?php
                                        $sql3 = $koneksi->query("SELECT * FROM detailpenjualan WHERE DetailID='".$data['PenjualanID']."' ");
                                        while($data3 = $sql3->fetch_assoc()) { ?>
                                        <?php
                                            $sql4 = $koneksi->query("SELECT * FROM produk WHERE ProdukID='".$data3['ProdukID']."' ");
                                            while($data4 = $sql4->fetch_assoc()) { ?>
                                            <td><?php echo $data4['NamaProduk'] ?></td>
                                        <?php } ?>
                                            <td><?php echo $data3['JumlahProduk'] ?></td>
                                            <td>Rp. <?php echo number_format($data3['Subtotal']) ?></td>
                                            
                                        </tr>
                                    <?php
                                        $totalproduk = $data3['JumlahProduk'] * $data3['Subtotal'];
                                        $totalharga += $totalproduk;
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="2"><strong>Total Harga: </strong></td>
                                        <td colspan="2"><strong>Rp. <?php echo number_format("$totalharga") ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="wa.php" class="btn btn-outline-dark text-light btn-md btn-success float-end">Cash</a>
            <a href="qris.php" target="_blank" class="btn btn-outline-dark btn-md btn-outline-dark float-end me-3">Transfer</a>
            <a href="cetak-transaksi.php" target="_blank" class="btn btn-outline-dark btn-md btn-outline-dark float-end me-3">Cetak struk</a>
        </div>
    </div>
</div>