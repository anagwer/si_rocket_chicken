<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profil Saya</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profil</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-profile">Edit Profil</button>
                                </li>
                            </ul>

                            <div class="tab-content pt-2">
                                <!-- Profile Overview -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <?php 
                                    require 'dbcon.php';
                                    $id_pengguna = $_SESSION['ID'];
                                    $query = $conn->query("SELECT * FROM pengguna WHERE id_pengguna='$id_pengguna'");
                                    $user = $query->fetch_assoc();
                                    ?>
                                    <h5 class="card-title">Detail Profil</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nama</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['nama']) ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">No. Telepon</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['no_telp']) ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Username</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['username']) ?></div>
                                    </div>
                                </div>

                                <!-- Edit Profile Form -->
                                <div class="tab-pane fade pt-3" id="edit-profile">
                                    <form method="post">
                                        <input type="hidden" name="id_pengguna" value="<?= $user['id_pengguna'] ?>">

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control" id="fullName" value="<?= htmlspecialchars($user['nama']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="phone" class="col-md-4 col-lg-3 col-form-label">No. Telepon</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <span class="input-group-text">+62</span>
                                                    <input name="no_telp" type="text" class="form-control" id="phone" value="<?= htmlspecialchars($user['no_telp']) ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="username" type="text" class="form-control" id="Username" value="<?= htmlspecialchars($user['username']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Password" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control" id="Password" placeholder="Isi jika ingin mengganti password">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="update_profile" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <?php include('footer.php'); ?>
    <?php include('script.php'); ?>
</body>
</html>
<?php
require 'dbcon.php';

if (isset($_POST['update_profile'])) {
    $id_pengguna = intval($_POST['id_pengguna']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    if (!empty($password)) {
        $password_hashed = md5($password); // Menggunakan MD5
        $conn->query("UPDATE pengguna SET nama='$nama', no_telp='$no_telp', username='$username', password='$password_hashed' WHERE id_pengguna='$id_pengguna'");
    } else {
        $conn->query("UPDATE pengguna SET nama='$nama', no_telp='$no_telp', username='$username' WHERE id_pengguna='$id_pengguna'");
    }

    echo "<script>alert('Profil berhasil diperbarui'); window.location='profil.php'</script>";
}
?>