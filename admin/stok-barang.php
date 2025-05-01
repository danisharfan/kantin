<div class="row">
    <div class="col-lg-12">
        <h4>Daftar Barang</h4>
        <?php
        if($level == "Admin") { ?>
        <a href="?page=tambah-barang" class="btn btn-sm btn-primary">Tambah Barang
+</a>
        <?php } ?>

<div class="table-responsive">
    <table class="table" width="100%" cellspacing="0">
    <thead>
        <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Terjual</th>
        <th>Aksi</th>
        </tr>
</thead>
<tbody>
    <?php
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM produk ORDER BY ProdukID DESC");
        while ($data = $sql->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo "<img src='./foto/".$data['Foto']."' width='70' height='70'>"; ?></td>
        <td><?php echo $data['NamaProduk']; ?></td>
        <td>Rp. <?php echo number_format($data['Harga']); ?></td>
        <td><?php echo $data['Stok']; ?></td>
        <td><?php echo $data['Terjual']; ?></td>
        <td>
            <a href="?page=edit-barang&id=<?php echo $data['ProdukID']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')" 
             href="?page=hapus-barang&id=<?php echo $data['ProdukID']; ?>" 
             class="btn btn-sm btn-danger">Delete</a>

        </td>
    </tr>
<?php } ?>
</tbody>
           
    </table>
        </div>
    </div>
</div>