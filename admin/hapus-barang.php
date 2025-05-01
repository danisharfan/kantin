<?php
// Pastikan parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data produk untuk mendapatkan nama file foto
    $query = $koneksi->query("SELECT Foto FROM produk WHERE ProdukID = '$id'");
    $data = $query->fetch_assoc();

    // Jika ada foto, hapus dari folder 'foto/'
    if (!empty($data['Foto']) && file_exists("foto/" . $data['Foto'])) {
        unlink("foto/" . $data['Foto']);
    }

    // Hapus produk dari database berdasarkan ProdukID
    $sql = $koneksi->query("DELETE FROM produk WHERE ProdukID = '$id'");

    // Redirect kembali ke halaman stok
    if ($sql) {
        echo "<script>
        alert('Berhasil menghapus barang');
        window.location.replace('index.php?page=stok-barang');
        </script>";
    } else {
        echo "<script>
        alert('Gagal menghapus barang');
        window.location.replace('index.php?page=stok-barang');
        </script>";
    }
} else {
    echo "<script>
    alert('ID barang tidak ditemukan');
    window.location.replace('index.php?page=stok-barang');
    </script>";
}
?>
