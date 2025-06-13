<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Pengguna</h5>
                            <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPenggunaModal">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>No. Telepon</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require 'dbcon.php';
                                        $no = 1;
                                        $query = $conn->query("SELECT * FROM pengguna ORDER BY id_pengguna DESC");

                                        while ($row = $query->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama']) ?></td>
                                            <td><?= htmlspecialchars($row['no_telp']) ?></td>
                                            <td><?= htmlspecialchars($row['username']) ?></td>
                                            <td>
                                                <?php if ($row['role'] == 'Admin'): ?>
                                                    <span class="badge bg-danger"><?= $row['role'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= $row['role'] ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPengguna<?= $row['id_pengguna'] ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusPengguna<?= $row['id_pengguna'] ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editPengguna<?= $row['id_pengguna'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_pengguna" value="<?= $row['id_pengguna'] ?>">
                                                            <div class="mb-3">
                                                                <label>Nama</label>
                                                                <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                                                    <input type="text" class="form-control" name="no_telp"  value="<?= htmlspecialchars($row['no_telp']) ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Username</label>
                                                                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['username']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Password (kosongkan jika tidak diubah)</label>
                                                                <input type="password" class="form-control" name="password">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Role</label>
                                                                <select class="form-select" name="role">
                                                                    <option value="Admin" <?= $row['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                                    <option value="Pelanggan" <?= $row['role'] == 'Pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="update_pengguna" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="hapusPengguna<?= $row['id_pengguna'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_pengguna" value="<?= $row['id_pengguna'] ?>">
                                                            <p>Yakin ingin menghapus pengguna <strong><?= htmlspecialchars($row['nama']) ?></strong>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="delete_pengguna" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahPenggunaModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label>No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                                <input type="text" class="form-control" name="no_telp" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select class="form-select" name="role">
                                <option value="Admin">Admin</option>
                                <option value="Pelanggan" selected>Pelanggan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="save_pengguna" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <?php include('script.php'); ?>
</body>
</html>

<?php
require 'dbcon.php';

// Simpan Data
if (isset($_POST['save_pengguna'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $conn->query("INSERT INTO pengguna (nama, no_telp, username, password, role)
                  VALUES ('$nama', '$no_telp', '$username', '$password', '$role')");
    
    echo "<script>window.location='pengguna.php'</script>";
}

// Update Data
if (isset($_POST['update_pengguna'])) {
    $id_pengguna = intval($_POST['id_pengguna']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = md5($password);
        $conn->query("UPDATE pengguna SET nama='$nama', no_telp='$no_telp', username='$username', password='$password', role='$role' WHERE id_pengguna='$id_pengguna'");
    } else {
        $conn->query("UPDATE pengguna SET nama='$nama', no_telp='$no_telp', username='$username', role='$role' WHERE id_pengguna='$id_pengguna'");
    }

    echo "<script>window.location='pengguna.php'</script>";
}

// Hapus Data
if (isset($_POST['delete_pengguna'])) {
    $id_pengguna = intval($_POST['id_pengguna']);
    $conn->query("DELETE FROM pengguna WHERE id_pengguna='$id_pengguna'");
    echo "<script>window.location='pengguna.php'</script>";
}
?>