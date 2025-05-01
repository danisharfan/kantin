<?php
include("./admin/koneksi.php");

// Ambil transaksi terakhir
$sql = $koneksi->query("SELECT * FROM penjualan ORDER BY PenjualanID DESC LIMIT 1");
$data = $sql->fetch_assoc();
$penjualanID = $data['PenjualanID'];
$tanggal = $data['TanggalPenjualan'];

// Ambil data pelanggan
$sql2 = $koneksi->query("SELECT * FROM pelanggan WHERE PelangganID='".$penjualanID."'");
$pelanggan = $sql2->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
        }
        .struk {
            width: 300px;
            margin: auto;
            border: 1px dashed #000;
            padding: 10px;
        }
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        table {
            width: 100%;
            font-size: 14px;
        }
        td, th {
            padding: 4px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="struk">
        <h3>Waroenk</h3>
        <p><strong>Tanggal:</strong> <?php echo $tanggal; ?></p>
        <p><strong>Pelanggan:</strong> <?php echo $pelanggan['NamaPelanggan']; ?></p>
        <p><strong>No HP:</strong> <?php echo $pelanggan['NomerTelepon']; ?></p>

        <hr>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql3 = $koneksi->query("SELECT * FROM detailpenjualan WHERE DetailID='".$penjualanID."'");
                $grandTotal = 0;
                while($item = $sql3->fetch_assoc()) {
                    $produkQuery = $koneksi->query("SELECT * FROM produk WHERE ProdukID='".$item['ProdukID']."'");
                    $produk = $produkQuery->fetch_assoc();
                    $subtotal = $item['Subtotal'];
                    $grandTotal += $subtotal;
                ?>
                <tr>
                    <td><?php echo $produk['NamaProduk']; ?></td>
                    <td class="text-right"><?php echo $item['JumlahProduk']; ?></td>
                    <td class="text-right">Rp. <?php echo number_format($subtotal); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td class="text-right"><strong>Rp. <?php echo number_format($grandTotal); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <hr>
        <div class="footer">
            Terima kasih telah berbelanja di Waroenk.<br>
            Barang yang sudah dibeli tidak dapat dikembalikan.
        </div>
    </div>
</body>
</html>