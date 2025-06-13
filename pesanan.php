<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <!-- Navigation -->
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Pesanan</h5>
                            <a href="https://wa.me/6285649611744"  target="_blank" class="btn btn-primary">
                                <i class="bi bi-whatsapp"></i> Chat Admin
                            </a><hr>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Pengguna</th>
                                            <th>Tanggal Pesan</th>
                                            <th>Total Harga</th>
                                            <th>Layanan</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require 'dbcon.php';
                                        $no = 1;
                                        $id = $_SESSION['ID'];
                                        $bool = false;
                                        if($_SESSION['ROLE']=='Admin'){
                                            $query = $conn->query("SELECT pesanan.*, pengguna.* FROM pesanan join pengguna on pesanan.id_pengguna=pengguna.id_pengguna ORDER BY pesanan.tanggal_pesan DESC");
                                        }else{
                                            $query = $conn->query("SELECT pesanan.*, pengguna.* FROM pesanan join pengguna on pesanan.id_pengguna=pengguna.id_pengguna where pesanan.id_pengguna='$id' ORDER BY pesanan.tanggal_pesan DESC");
                                        }
                                        while ($row = $query->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama']); ?></td>
                                            <td><?= date('d M Y H:i', strtotime($row['tanggal_pesan'])); ?></td>
                                            <td>Rp. <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                            <td><?= htmlspecialchars($row['layanan']); ?></td>
                                            <td><?= htmlspecialchars($row['metode_pembayaran']); ?></td>
                                            <td>
                                                <?php if ($row['status'] == "Pending"): ?>
                                                    <span class="badge bg-warning"><?= $row['status'] ?></span>
                                                <?php elseif ($row['status'] == "Diproses"): ?>
                                                    <span class="badge bg-primary"><?= $row['status'] ?></span>
                                                <?php elseif ($row['status'] == "Selesai"): ?>
                                                    <span class="badge bg-success"><?= $row['status'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= $row['status'] ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id_pesanan'] ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <!-- Modal Detail Pesanan -->
                                                <div class="modal fade" id="detailModal<?= $row['id_pesanan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail Pesanan #<?= $row['id_pesanan'] ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nama Menu</th>
                                                                            <th>Harga</th>
                                                                            <th>Jumlah</th>
                                                                            <th>Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $id_pesanan = $row['id_pesanan'];
                                                                        $detailQuery = $conn->query("
                                                                            SELECT dp.jumlah, m.nm_menu, m.harga, (dp.jumlah * m.harga) AS subtotal 
                                                                            FROM detail_pesanan dp
                                                                            JOIN menu m ON dp.id_menu = m.id_menu
                                                                            WHERE dp.id_pesanan = '$id_pesanan'
                                                                        ");
                                                                        $ttl=0;
                                                                        while ($detail = $detailQuery->fetch_assoc()) {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?= htmlspecialchars($detail['nm_menu']) ?></td>
                                                                                <td>Rp. <?= number_format($detail['harga'], 0, ',', '.') ?></td>
                                                                                <td><?= $detail['jumlah'] ?></td>
                                                                                <td>Rp. <?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
                                                                            </tr>
                                                                        <?php $ttl=$ttl+$detail['subtotal'];} ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th colspan="3">Total</th>
                                                                            <th><?php echo $ttl;?></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($row['status']=='Pending'){?>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_pesanan<?= $row['id_pesanan'] ?>"><i class="bi bi-trash"></i></button>
                                                
                                                <?php }
                                                 require 'delete_pesanan.php';
                                                 if ($_SESSION['ROLE'] == 'Admin'): ?>
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editStatus<?= $row['id_pesanan'] ?>"><i class="bi bi-pencil"></i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Status -->
                                        <div class="modal fade" id="editStatus<?= $row['id_pesanan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Status Pesanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_pengguna" value="<?= $row['id_pengguna'] ?>">
                                                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                                            <label for="status">Pilih Status Baru:</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                                <option value="Diproses" <?= $row['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                                                <option value="Selesai" <?= $row['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                                <option value="Batal" <?= $row['status'] == 'Batal' ? 'selected' : '' ?>>Batal</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="update_status" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                               
                                            </div>
                                        </div>
                                        <?php } ?> 
                                        <?php 
                                                if (isset($_POST['update_status'])) {
                                                    $id_pengguna = $_POST['id_pengguna'];
                                                    $id_pesanan = $_POST['id_pesanan'];
                                                    $status = $_POST['status'];

                                                    $conn->query("UPDATE pesanan SET status = '$status' WHERE id_pesanan = '$id_pesanan'");
                                                    $isi_notifikasi = "Pesanan kamu telah $status.";
                                                  
                                                    $insert_notifikasi = $conn->query("INSERT INTO notifikasi (id_pengguna, id_pesanan, waktu_kirim, isi_notifikasi,status)
                                                        VALUES ('$id_pengguna', '$id_pesanan', CURRENT_TIMESTAMP(), '$isi_notifikasi','Unread')");
                                                    
                                                    echo "<script>window.location='pesanan.php';</script>";
                                                }
                                                ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->
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