<?php
$Id = $_GET['Id'];

$sql = $koneksi->query("DELETE FROM user WHERE UserID = '$Id'");
echo "<script>alert('Berhasil menghapus user'); 
window.location.href='index.php?page=user'</script>";
?>