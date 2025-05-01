<?php
$id = $_GET['UserID'];

$sql = $koneksi->query("SELECT * FROM user WHERE UserID = '$id'");
$data = $sql->fetch_assoc();

if (isset($_POST['submit'])) {
    $Username = $_POST['Username'];
    $Level = $_POST['Level'];
    $Password = md5($_POST['Password']);
    $sql = $koneksi->query("UPDATE user SET Username='$Username', Password='$Password', Level='$Level' WHERE UserID='$id'");
    echo "<script>alert('Berhasil Mengubah data User');window.location.href='?page=user';</script>";
} else {
    # code...
}

?>

<div class="col-md-4">
    <div class="card well">
        <h3>Tambah User</h3>
        <form action="" method="post">
            <div class="">
                <label for="Username" class="form-label">Username: <span style="color: red;">*</span></label>
                <input type="text" value="<?php echo $data['Username'] ?>" name="Username" id="Username" class="form-control" placeholder="Masukkan Username" required>
            </div>
            <div class="">
                <label for="Password" class="form-label">Password: <span style="color: red;">*</span></label>
                <input type="text" name="Password" id="Password" class="form-control" placeholder="Masukkan Password" required>
            </div>
            <div class="">
                <label for="Level" class="form-label">Level: <span style="color: red;">*</span></label>
                <select name="Level" id="Level" class="form-control">
                    <?php
                    if ($data['Level'] == "Admin") { ?>
                        <option value="Admin">Admin</option>
                        <option value="Petugas">Petugas</option>
                    <?php } else { ?>
                        <option value="Petugas">Petugas</option>
                        <option value="Admin">Admin</option>
                    <?php } ?>
                </select>
            </div>
            <p></p>
            <button type="submit" name="submit" class="btn btn-md btn-primary">Tambah</button>
        </form>
    </div>
</div>