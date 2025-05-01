<?php
// Pastikan parameter 'id' ada di URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID Produk tidak ditemukan!');window.location.href='?page=stok';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data produk berdasarkan ID
$sql = $koneksi->query("SELECT * FROM produk WHERE ProdukID = '$id'");
$data = $sql->fetch_assoc();

// Jika produk tidak ditemukan
if (!$data) {
    echo "<script>alert('Produk tidak ditemukan!');window.location.href='?page=stok';</script>";
    exit;
}

// Jika form disubmit
if (isset($_POST['submit'])) {
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];
    $FotoLama = $data['Foto'];  // Menyimpan nama foto lama untuk validasi

    // Cek jika ada foto baru yang diupload
    if ($_FILES['Foto']['name']) {
        $Foto = $_FILES['Foto']['name'];
        $target_dir = "foto/";
        $target_file = $target_dir . basename($Foto);

        // Upload file foto baru
        if (move_uploaded_file($_FILES['Foto']['tmp_name'], $target_file)) {
            // Hapus foto lama jika ada
            if (!empty($FotoLama) && file_exists("foto/$FotoLama")) {
                unlink("foto/$FotoLama");
            }
        } else {
            echo "<script>alert('Gagal mengupload foto');</script>";
        }
    } else {
        // Jika tidak ada foto baru, gunakan foto lama
        $Foto = $FotoLama;
    }

    // Update data produk di database
    $sql = $koneksi->query("UPDATE produk SET NamaProduk='$NamaProduk', Harga='$Harga', Stok='$Stok', Foto='$Foto' WHERE ProdukID='$id'");

    // Redirect setelah berhasil update
    if ($sql) {
        echo "<script>alert('Berhasil mengubah data barang');window.location.href='?page=stok-barang';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data barang');</script>";
    }
}
?>

<div class="col-md-4">
    <div class="card well">
        <h3>Edit Barang</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="">
                <label for="NamaProduk" class="form-label">Nama Produk: <span style="color: red;">*</span></label>
                <input type="text" value="<?php echo htmlspecialchars($data['NamaProduk']); ?>" name="NamaProduk" id="NamaProduk" class="form-control" placeholder="Masukkan Nama Produk" required>
            </div>
            <div class="">
                <label for="Harga" class="form-label">Harga: <span style="color: red;">*</span></label>
                <input type="number" value="<?php echo $data['Harga']; ?>" name="Harga" id="Harga" class="form-control" placeholder="Masukkan Harga" required>
            </div>
            <div class="">
                <label for="Stok" class="form-label">Stok: <span style="color: red;">*</span></label>
                <input type="number" value="<?php echo $data['Stok']; ?>" name="Stok" id="Stok" class="form-control" placeholder="Masukkan Stok" required>
            </div>
            <div class="">
                <label for="Foto" class="form-label">Foto Produk:</label>
                <input type="file" name="Foto" id="Foto" class="form-control">
                <p>Foto Lama: <img src="./foto/<?php echo $data['Foto']; ?>" width="70" height="70" alt="Foto Produk"></p>
            </div>
            <p></p>
            <button type="submit" name="submit" class="btn btn-md btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
