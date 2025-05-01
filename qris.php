<?php
include("./admin/koneksi.php");

// Ambil pesanan terakhir
$sql = $koneksi->query("SELECT * FROM penjualan ORDER BY PenjualanID DESC LIMIT 1");
$data = $sql->fetch_assoc();
$penjualanID = $data['PenjualanID'];

// Ambil data pelanggan
$sql2 = $koneksi->query("SELECT * FROM pelanggan WHERE PelangganID='".$penjualanID."'");
$pelanggan = $sql2->fetch_assoc();

// Hitung total
$sql3 = $koneksi->query("SELECT * FROM detailpenjualan WHERE DetailID='".$penjualanID."'");
$totalBayar = 0;
while ($item = $sql3->fetch_assoc()) {
    $totalBayar += $item['Subtotal'];  // Jumlahkan subtotal dari setiap item
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Bayar QRIS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        .qris-img {
            width: 300px;
            height: auto;
            margin-bottom: 25px;
        }

        .info {
            margin-top: 12px;
            font-size: 20px;
        }

        .total {
            font-size: 26px;
            font-weight: bold;
            margin-top: 25px;
            color: #4863A0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Pembayaran QRIS</h2>
        <p class="info">Silakan scan QRIS berikut untuk membayar</p>
        <img src="qris.jpg" alt="QRIS" class="qris-img">
        <p class="total">Total: Rp. <?php echo number_format($totalBayar); ?></p>
        <p class="info">Atas nama: <?php echo $pelanggan['NamaPelanggan']; ?></p>
    </div>
</body>
</html>