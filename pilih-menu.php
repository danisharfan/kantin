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
                        <a href="index.php" class="nav-link text-light">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="pilih-menu.php" class=" btn btn-outline-light mx-2 shadow">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="pesan-menu.php" class="nav-link text-light">Pesan</a>
                    </li>
                </ul>
            </div>
            <a href="admin/login.php" class="float-end btn btn-outline-light mx-2 shadow">admin</a>
        </div>
    </nav>
<div class="main-content" style="background-color: whitesmoke;">
    <div class="ms-4 me-4">
        <div class="mb-4">
            <h2>Selamat datang di Waroenk!</h2>
            <p>Silakan jelajahi menu kami dan temukan hidangan lezat untuk Anda nikmati. Jangan ragu untuk memesan jika Anda menemukan menu yang Anda sukai.</p>
        </div>
        <form action="" name="search" method="post">
            <div class="row">
                <div class="form-group col-sm-12 mt-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari menu..">
                </div>
            </div>
        </form>
    </div>
    <div class="card-container">
        <?php
        if (isset($_POST['search'])) {
            $nama = $_POST['search'];
            $sql = $koneksi->query("SELECT * FROM produk WHERE NamaProduk LIKE '%$nama%'");
            if ($sql->num_rows > 0) {
                while($data = $sql->fetch_assoc()) {
        ?>
                <div class="card" style="width: 18rem;margin: 10px;">
                    <?php echo "<img class='card-img-top' src='admin/foto/".$data['Foto']."'  width='230' height='250'></img>"; ?>
                    <div class="card-body">
                        <h5 class="card-text"><?php echo $data['NamaProduk'] ?></h5>
                        <p class="card-text">Harga: Rp.<?php echo number_format($data['Harga']) ?></p>
                        <p class="card-text">Tersedia: <?php echo $data['Stok'] ?>Pcs</p>
                        <a href="pesan-menu.php?id=<?= $data['ProdukID'] ?>" style="background-color: #4863A0;" class="btn btn-sm text-light col-12">Beli</a>
                    </div>
                </div>
                <?php  } 
            } else {
                echo "<p class='mt-3'>Tidak ada menu yang ditemukan dengan nama $nama. <a href='index.php'>kembali ke halaman sebelumnya</a></p>";
            }
        } else {
            $sql = $koneksi->query("SELECT * FROM produk ORDER BY ProdukID DESC");
            while ($data = $sql->fetch_assoc()) {
        ?>
            <div class="card" style="width: 18rem;margin: 10px;">
                <?php echo "<img class='card-img-top' src='admin/foto/".$data['Foto']."'  width='230' height='250'></img>"; ?>
                <div class="card-body">
                    <h5 class="card-text"><?php echo $data['NamaProduk'] ?></h5>
                    <p class="card-text">Harga: Rp.<?php echo number_format($data['Harga']) ?></p>
                    <p class="card-text">Tersedia: <?php echo $data['Stok'] ?> Pcs</p>
                    <a href="pesan-menu.php?id=<?= $data['ProdukID'] ?>" style="background-color: #4863A0;" class="btn btn-sm col-12 btn-outline-dark text-light shadow">Beli</a>
                </div>
            </div>
        <?php } }?>
    </div>
</div>