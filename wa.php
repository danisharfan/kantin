<?php
include("admin/koneksi.php");
?>

<?php
$totalharga = 0;
$sql = $koneksi->query("SELECT * FROM penjualan ORDER BY PenjualanID DESC");
$data = $sql->fetch_assoc()
?>
<?php $id = $data['PenjualanID']; ?>
<?php $tgl = $data['TanggalPenjualan']; ?>
<?php
$sql2 = $koneksi->query("SELECT * FROM pelanggan WHERE PelangganID='" . $data['PenjualanID'] . "' ");
while ($data2 = $sql2->fetch_assoc()) { ?>
    <?php $nama = $data2['NamaPelanggan']; ?>
    <?php $tlp = $data2['NomerTelepon']; ?>
<?php } ?>
<?php

$token = "5ncYzvJyF9kTxGP54cMa";
$target = $tlp;

$message = "
ID Pesan: $id

Tanggal Pesanan: $tgl

Nama Pesanan: $nama

Nomor Telepon: $tlp

";

// Loop untuk menambahkan setiap item produk ke dalam pesan
$sql3 = $koneksi->query("SELECT * FROM detailpenjualan WHERE DetailID='" . $data['PenjualanID'] . "' ");
while ($data3 = $sql3->fetch_assoc()) {
    $sql4 = $koneksi->query("SELECT * FROM produk WHERE ProdukID='" . $data3['ProdukID'] . "' ");
    while ($data4 = $sql4->fetch_assoc()) {
        $np = $data4['NamaProduk'];
        $jp = $data3['JumlahProduk'];
        $st = number_format($data3['Subtotal']);
        $hm = "==================================";
        $message .= "
$hm
Nama Produk: $np
jumlah: $jp
Harga: Rp. $st
";
    }
    
    $totalproduk = $data3['JumlahProduk'] * $data3['Subtotal'];
    $totalharga += $totalproduk;
    $th = number_format("$totalharga");
}

$message .= "

Total Belanjaan Anda: $th
==================================
Terima kasih ";





$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => $message,
        'countryCode' => '62', //optional   
    ),
    CURLOPT_HTTPHEADER => array(
        "Authorization: $token" //change TOKEN to your actual token
    ),
));
$response = curl_exec($curl);
if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
    // Jika terjadi kesalahan curl, tampilkan pesan kesalahan
    echo $error_msg;
} else {
    // Jika pengiriman pesan berhasil, lakukan redirect
    echo "<script>alert('Berhasil Mengirim Pesan Whatsapp Ke Nomor Pelanggan');window.location.href='pilih-menu.php';</script>";
    exit; // Pastikan untuk keluar dari skrip setelah melakukan redirect
}
curl_close($curl);