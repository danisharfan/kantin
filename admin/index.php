<?php
session_start();
include("./koneksi.php");

if ($_SESSION['Username'] == "") {
    header("Location: login.php");
}

$user = $_SESSION['Username'];
$level = $_SESSION['Level'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <script src="../assets/jquery.min.js"></script>
    <script src="../assets/bootstrap.min.js"></script>
    <style>
        .row.content {
            height: 640px;
        }

        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }

        @media screen and (max-width: 767px) {
            .row.content {height: auto;}
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-3 sidenav hidden-xs">
                <h2><?php echo ucfirst($level); ?></h2>
                <ul class="nav nav-pills nav-stacked">
                    <li <?php if (isset($_GET['page']) && $_GET['page'] == 'dashboard') echo 'class="active"'; ?>>
                        <a href="?page=dashboard">Dashboard</a>
                    </li>
                    <li <?php if (isset($_GET['page']) && $_GET['page'] == 'user') echo 'class="active"'; ?>>
                        <a href="?page=user">User</a>
                    </li>
                    <li <?php if (isset($_GET['page']) && $_GET['page'] == 'stok-barang') echo 'class="active"'; ?>>
                        <a href="?page=stok-barang">Stok</a>
                    </li>
                    <li <?php if (isset($_GET['page']) && $_GET['page'] == 'daftar-transaksi') echo 'class="active"'; ?>>
                        <a href="?page=daftar-transaksi">Daftar Tranksaksi</a>
                    </li>
                    <li><a href="../pilih-menu.php">Beranda</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

            <div class="col-sm-9">
                <?php
                if (isset($_GET['page'])) {
                    $halaman = $_GET['page'];

                    switch ($halaman) {
                        case "dashboard":
                            include "dashboard.php";
                            break;
                        case "user":
                            include "user.php";
                            break;
                        case "tambah-user":
                            include "tambah-user.php";
                            break;
                        case "edit-user":
                            include "edit-user.php";
                            break;
                        case "hapus-user":
                            include "hapus-user.php";
                            break;
                        case "stok-barang":
                            include "stok-barang.php";
                            break;
                        case "tambah-barang":
                            include "tambah-barang.php";
                            break;
                        case "edit-barang":
                            include "edit-barang.php";
                            break;
                        case "hapus-barang":
                            include "hapus-barang.php";
                            break;
                        case 'cari-barang':
                            include "cari-barang.php";
                            break;
                        case 'daftar-transaksi':
                            include "daftar-transaksi.php";
                            break;
                        case 'hapus-daftar-transaksi':
                            include "hapus-daftar-transaksi.php";
                            break;
                    }
                } else {
                    include "dashboard.php";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>