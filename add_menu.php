<!-- Modal Tambah Menu -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" name="nm_menu" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Ketersediaan</label>
                        <select class="form-select" name="ketersediaan">
                            <option>Tersedia</option>
                            <option>Kosong</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Foto Menu</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
require_once 'dbcon.php';

if (isset($_POST['save'])) {

    $nm_menu = $_POST['nm_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $ketersediaan = $_POST['ketersediaan'];

    // Upload gambar
    $target_dir = "upload/menu/";
    $file_name = basename($_FILES["gambar"]["name"]);
    $uniqname = uniqid() . "-" . $file_name;
    $target_file = $target_dir . $uniqname;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowed_types = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>alert('Hanya file JPG, JPEG, PNG, atau GIF yang diperbolehkan.'); window.history.back();</script>";
        exit();
    }

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Simpan ke database
        $sql = "INSERT INTO menu VALUES (
            NULL, 
            '$nm_menu', 
            '$deskripsi', 
            '$harga', 
            '$ketersediaan', 
            '$uniqname'
        )";

        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href='menu.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data menu.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah gambar.'); window.history.back();</script>";
    }
}
?>