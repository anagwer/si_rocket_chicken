<?php if (!$bool): ?>

<div class="modal fade" id="edit_menu<?php echo $row['id_menu']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="id_menu" value="<?php echo $row['id_menu']; ?>">
                    <input type="hidden" name="old_img" value="<?php echo $row['img']; ?>">

                    <div class="form-group mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" name="nm_menu" value="<?php echo $row['nm_menu'];?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3"><?php echo $row['deskripsi'];?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" value="<?php echo $row['harga'];?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Ketersediaan</label>
                        <select class="form-select" name="ketersediaan">
                            <option><?php echo $row['ketersediaan'];?></option>
                            <option>Tersedia</option>
                            <option>Kosong</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Foto Menu (kosongkan jika tidak ingin mengganti)</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="update" class="btn btn-success">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update'])) {
    $id_menu = $_POST['id_menu'];
    $nm_menu = $_POST['nm_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $ketersediaan = $_POST['ketersediaan'];
    $old_img = $_POST['old_img'];

    // Upload gambar baru jika ada
    if (!empty($_FILES["gambar"]["name"])) {
        $target_dir = "upload/menu/";
        $file_name = basename($_FILES["gambar"]["name"]);
        $uniqname = uniqid() . "-" . $file_name;
        $target_file = $target_dir . $uniqname;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Hanya file JPG, JPEG, PNG, atau GIF yang diperbolehkan.'); window.history.back();</script>";
            exit();
        }

        if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "<script>alert('Gagal mengunggah gambar baru.'); window.history.back();</script>";
            exit();
        }

        // Hapus foto lama
        if (file_exists("upload/menu/" . $old_img)) {
            unlink("upload/menu/" . $old_img);
        }

        $new_img = $uniqname;
    } else {
        $new_img = $old_img;
    }

    // Update ke database
    $conn->query("UPDATE menu SET 
        nm_menu = '$nm_menu',
        deskripsi = '$deskripsi',
        harga = '$harga',
        ketersediaan = '$ketersediaan',
        img = '$new_img'
        WHERE id_menu = '$id_menu'
    ") or die(mysqli_error($conn));

    echo "<script>window.location.href='menu.php';</script>";
}
?>
                                
<?php endif; ?>