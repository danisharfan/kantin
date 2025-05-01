<?php
include("header.php");
include("admin/koneksi.php");

date_default_timezone_set('Asia/Jakarta');

$id = isset($_GET['id']) ? $_GET['id'] : "";


if (isset($_POST['submit'])) {
    $tanggal = date("Y-m-d H:i:s", strtotime($_POST['tanggal']));
    $nama = $_POST['nama'];
    $nomertelepon = $_POST['NomerTelepon'];
    $menu_jumlah = $_POST['menu'];
    $jumlah_array = $_POST['jumlah'];
    $stok = true;

    foreach ($menu_jumlah as $i => $item) {
        $parts = explode("|", $item);
        $produk_id = $parts[0];
        $harga = $parts[1];
        $jumlah = $jumlah_array[$i];

        $sql = $koneksi->query("SELECT Stok FROM produk WHERE ProdukID = '$produk_id'");
        $row = $sql->fetch_assoc();
        $stok_produk = $row['Stok'];

        if ($jumlah > $stok_produk) {
            $stok = false;
            break;
        }
    }

    if ($stok) {
        $sql = $koneksi->query("INSERT INTO penjualan (TanggalPenjualan) VALUES ('$tanggal')");
        $id_transaksi = mysqli_insert_id($koneksi);
        $sql = $koneksi->query("INSERT INTO pelanggan (PelangganID, NamaPelanggan, NomerTelepon) VALUES ('$id_transaksi', '$nama','$nomertelepon')");

        foreach ($menu_jumlah as $i => $item) {
            $parts = explode("|", $item);
            $produk_id = $parts[0];
            $harga = $parts[1];
            $jumlah = $jumlah_array[$i];
        
            $sql = $koneksi->query("INSERT INTO detailpenjualan (DetailID, ProdukID, JumlahProduk, Subtotal) VALUES ('$id_transaksi', '$produk_id', '$jumlah', '$harga')");
            $sql = $koneksi->query("UPDATE produk SET Stok = Stok - $jumlah WHERE ProdukID='$produk_id'");
            $sql = $koneksi->query("UPDATE produk SET Terjual = Terjual + $jumlah WHERE ProdukID='$produk_id'");
        }

        header("Location: pesanan.php");
        exit();
    } else {
        echo "<script>alert('Maaf, Jumlah pesanan melebihi stok yang tersedia. Silakan periksa kembali pesanan anda')</script>";
    }
    
}
?>

<script>
    function tambahMenu() {
        var container = document.getElementById("menuContainer");
        var newMenuInput = document.createElement("div");

        newMenuInput.innerHTML = `
        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="menu" class="form-label">Menu: <span style="color: red;">*</span></label>
                                <select name="menu[]" onchange="showDetails(this)" id="menu" class="form-control">
                                    <option value="">Pilih Menu</option>
                                    <?php
                                        $sql = $koneksi->query("SELECT * FROM produk WHERE Stok > 0");
                                        while ($data = $sql->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $data['ProdukID'] . '|' . $data['Harga'] . '|' . $data['Stok'];  ?>"><?php echo $data['NamaProduk']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="harga" class="form-label">Harga:</label>
                                <input type="text" name="harga" id="harga" class="form-control harga" disabled>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="stok" class="form-label">Stok:</label>
                                <input type="text" name="stok" id="stok" class="form-control stok" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah: <span style="color: red;">*</span></label>
                            <input type="number" min="1" name="jumlah[]" id="jumlah" class="form-control" placeholder="Masukkan jumlah" required>
                            <button type="button" onclick="hapusMenu(this)" class="btn btn-danger mt-3 col-12">Hapus</button>
                        </div>
        `;

        container.appendChild(newMenuInput);
    }

    function hapusMenu(button) {
        var divToRemove = button.parentNode.parentNode;
        divToRemove.remove();
    }

    function showDetails(select) {
        var menu = select.value;
        var menuDetails = menu.split('|');
        var formattedPrice = Number(menuDetails[1]).toLocaleString('id-ID');
        var parentDiv = select.closest(".row");
        var hargaInput = parentDiv.querySelector(".harga");
        var stokInput = parentDiv.querySelector(".stok");
        hargaInput.value = "Rp. " + formattedPrice;
        stokInput.value = menuDetails[2];
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        var menuSelects = document.querySelectorAll("#menuContainer select");
        menuSelects.forEach(function(select) {
            showDetails(select);
        });
    });
</script>
<nav style="background-color: #4863A0;"class="navbar navbar-expand-sm navbar-secondary fixed-top">
        <div class="container-fluid">
            <a href="#" class="navbar-brand text-light">Waroenk</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-light">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="pilih-menu.php" class="nav-link text-light">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="pesan-menu.php" class="btn btn-outline-light mx-2 shadow">Pesan</a>
                    </li>
                </ul>
            </div>
            <a href="login.php" class="float-end btn btn-outline-light mx-2 shadow">Login</a>
        </div>
    </nav>
<div class="p-4">
    <div class="card" style="background-color: whitesmoke;">
        <div class="card-body">
            <div class="container">
                <h2>Buat Pesanan</h2>
                <form action="" method="post">
                    <div>
                        <label for="tanggal" class="form-label">Tanggal Pemesanan: <span style="color: red;">*</span></label>
                        <input type="text" value="<?php echo date("Y-m-d H:i:s") ?>" name="tanggal" id="tanggal" class="form-control" placeholder="Masukkan tanggal" required readonly>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="nama" class="form-label">Atas Nama: <span style="color: red;">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="NomerTelepon" class="form-label">No Telepon: <span style="color: red;">*</span></label>
                            <input type="text" min="1" name="NomerTelepon" id="NomerTelepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                        </div>
                    </div>
                    <div id="menuContainer">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="menu" class="form-label">Menu: <span style="color: red;">*</span></label>
                                <select name="menu[]" onchange="showDetails(this)" id="menu" class="form-control" required>
                                    <?php
                                        if ($id != "") {
                                            $sql2 = $koneksi->query("SELECT * FROM produk WHERE ProdukID = '$id' AND Stok > 0");
                                            $data2 = $sql2->fetch_assoc() ?>
                                                <option value="<?php echo $data2['ProdukID'] . '|' . $data2['Harga'] . '|' . $data2['Stok'];  ?>"><?php echo $data2['NamaProduk']; ?></option>
                                            <?php
                                                $sql = $koneksi->query("SELECT * FROM produk WHERE Stok > 0");
                                                while ($data = $sql->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo $data['ProdukID'] . '|' . $data['Harga'] . '|' . $data['Stok'];  ?>"><?php echo $data['NamaProduk']; ?></option>
                                            <?php }
                                        } else { ?>
                                            <option value="">Pilih Menu</option>
                                    <?php
                                            $sql = $koneksi->query("SELECT * FROM produk WHERE Stok > 0");
                                            while ($data = $sql->fetch_assoc()) { ?>
                                                <option value="<?php echo $data['ProdukID'] . '|' . $data['Harga'] . '|' . $data['Stok'];  ?>"><?php echo $data['NamaProduk']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="harga" class="form-label">Harga:</label>
                                <input type="text" name="harga" id="harga" class="form-control harga" disabled>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="stok" class="form-label">Stok:</label>
                                <input type="text" name="stok" id="stok" class="form-control stok" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah: <span style="color: red;">*</span></label>
                            <input type="number" min="1" name="jumlah[]" id="jumlah" class="form-control" placeholder="Masukkan jumlah" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning btn-outline-dark me-3" onclick="tambahMenu()">+</button>
                    <button type="submit" name="submit" class="btn btn-outline-dark text-light" style="background-color: #4863A0;">Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>