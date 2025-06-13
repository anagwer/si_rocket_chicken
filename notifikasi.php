<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <h5 class="card-title">Daftar Notifikasi</h5>

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Isi Notifikasi</th>
                                            <th>Waktu Kirim</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require 'dbcon.php';
                                        $id_pengguna = $_SESSION['ID'];
                                        $no = 1;

                                        // Ambil notifikasi berdasarkan id_pengguna
                                        $query = $conn->query("SELECT * FROM notifikasi WHERE id_pengguna = '$id_pengguna' ORDER BY waktu_kirim DESC");

                                        if ($query->num_rows == 0) {
                                            echo "<tr><td colspan='5' class='text-center'>Tidak ada notifikasi</td></tr>";
                                        }

                                        while ($row = $query->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['isi_notifikasi']) ?></td>
                                            <td><?= date('d M Y H:i', strtotime($row['waktu_kirim'])) ?></td>
                                            <td>
                                                <?php if ($row['status'] == 'Unread'): ?>
                                                    <span class="badge bg-warning"><?= $row['status'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-success"><?= $row['status'] ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] == 'Unread'): ?>
                                                <form method="post">
                                                    <input type="hidden" name="id_notifikasi" value="<?= $row['id_notifikasi'] ?>">
                                                    <button type="submit" name="mark_read" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check"></i> Tandai Dibaca
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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