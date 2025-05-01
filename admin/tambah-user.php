<div class="col-md-4">
    <div class="card well">
        <h3>Tambah User</h3>
        <form action="" method="post">
            <div class="">
                <label for="Username" class="form-label">Username: <span style="color: red;">
                    *</span></label>
                <input type="text" name="Username" id="Username" class="form-control" placeholder="Masukkan Username" required>
            </div>
            <div class="">
                <label for="Password" class="form-label">Password: <span style="color: red;">
                    *</span></label>
                <input type="text" name="Password" id="Password" class="form-control" placeholder="Masukkan Password" required>
            </div>
            <div class="">
                <label for="Level" class="form-label">Level: <span style="color: red;">*</span></label>
                <select name="Level" id="Level" class="form-control">
                    <option value="">Pilih Level</option>
                    <option value="Admin">Admin</option>
                    <option value="Petugas">Petugas</option>
                </select>
            </div>
            <p></p>
            <button type="submit" name="submit" class="btn btn-md btn-primary">Tambah</button>
        </form>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $Username = $_POST['Username'];
    $Level = $_POST['Level'];
    $Password = md5($_POST['Password']);
    $sql = $koneksi->query("INSERT INTO user(Username, Password, Level)
    VALUES('$Username', '$Password', '$Level')");
    echo "<script>alert('Berhasil menambahkan user'); 
    window.location.href='index.php?page=user'</script>";
    } else {
        # code...
    }
?>