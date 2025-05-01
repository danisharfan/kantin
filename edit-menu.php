<?php
include("header.php");
include("./admin/koneksi.php");

// Handle submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pelangganID = $_POST['pelanggan_id'];
    $produkID = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];

    // Buat tanggal sekarang
    $tanggal = date("Y-m-d");

    // Insert ke penjualan
    $koneksi->query("INSERT INTO penjualan (TanggalPenjualan, PelangganID) VALUES ('$tanggal', '$pelangganID')");
    $penjualanID = $koneksi->insert_id;

    // Ambil harga produk
    $produkQuery = $koneksi->query("SELECT Harga FROM produk WHERE ProdukID='$produkID'");
    $produk = $produkQuery->fetch_assoc();
    $subtotal = $produk['Harga'] * $jumlah;

    // Insert ke detail penjualan
    $koneksi->query("INSERT INTO detailpenjualan (DetailID, ProdukID, JumlahProduk, Subtotal) 
                     VALUES ('$penjualanID', '$produkID', '$jumlah', '$subtotal')");

    echo "<script>alert('Pesanan berhasil ditambahkan!'); window.location='pesan-menu.php';</script>";
}
?>

<div class="container mt-5 pt-5">
    <div class="card">
        <div class="card-header" style="background-color: #4863A0;">
            <h4 class="text-light">Tambah Pesanan</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="pelanggan_id" class="form-label">Pilih Pelanggan</label>
                    <select name="pelanggan_id" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $pelanggan = $koneksi->query("SELECT * FROM pelanggan");
                        while ($p = $pelanggan->fetch_assoc()) {
                            echo "<option value='{$p['PelangganID']}'>{$p['NamaPelanggan']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="produk_id" class="form-label">Pilih Menu</label>
                    <select name="produk_id" class="form-select" required>
                        <option value="">-- Pilih Menu --</option>
                        <?php
                        $produk = $koneksi->query("SELECT * FROM produk");
                        while ($pr = $produk->fetch_assoc()) {
                            echo "<option value='{$pr['ProdukID']}'>{$pr['NamaProduk']} - Rp. ".number_format($pr['Harga'])."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Pesanan</button>
                <a href="pesan-menu.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>