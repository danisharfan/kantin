<div class="col-md-4">
    <div class="card well">
        <h3>Tambah Stok Barang</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="">
                <label for="NamaProduk" class="form-label">Nama Produk: <span style="color: red;">*</span></label>
                <input type="text" name="NamaProduk" id="NamaProduk" class="form-control" placeholder="Masukkan Nama Produk" required>
            </div>
            <div class="">
                <label for="Harga" class="form-label">Harga: <span style="color: red;">*</span></label>
                <input type="number" name="Harga" id="Harga" class="form-control" placeholder="Masukkan Harga" required>
            </div>
            <div class="">
                <label for="Stok" class="form-label">Stok: <span style="color: red;">*</span></label>
                <input type="number" name="Stok" id="Stok" class="form-control" placeholder="Masukkan Stok" required>
            </div>
            <div class="">
                <label for="Foto" class="form-label">Foto Produk:</label>
                <input type="file" name="Foto" id="Foto" class="form-control">
            </div>
            <p></p>
            <button type="submit" name="submit" class="btn btn-md btn-primary">Tambah</button>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];

    // Folder tujuan penyimpanan file
    $target_dir = "foto/";

    // Ambil informasi file
    $Foto = $_FILES['Foto']['name'];
    $target_file = $target_dir . basename($Foto);

    // Cek apakah folder ada, jika tidak maka buat
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Cek apakah file diunggah
    if (!empty($_FILES['Foto']['tmp_name'])) {
        if (move_uploaded_file($_FILES['Foto']['tmp_name'], $target_file)) {
            $sql = $koneksi->query("INSERT INTO produk (NamaProduk, Harga, Stok, Foto) 
            VALUES ('$NamaProduk', '$Harga', '$Stok', '$Foto')");

            echo "<script>
            alert('Berhasil menambahkan stok barang');
            window.location.replace('index.php?page=stok-barang');
            </script>";
        } else {
            echo "<script>alert('Gagal mengupload foto');</script>";
        }
    } else {
        // Jika tidak ada foto yang diunggah, simpan data tanpa foto
        $sql = $koneksi->query("INSERT INTO produk (NamaProduk, Harga, Stok, Foto) 
        VALUES ('$NamaProduk', '$Harga', '$Stok', '')");

        echo "<script>
        alert('Stok barang berhasil ditambahkan tanpa foto');
        window.location.replace('index.php?page=stok-barang');
        </script>";
    }
}
?>
