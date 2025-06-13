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
                            <h5 class="card-title">Data Pesanan</h5>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDetailModal"><i class="bi bi-plus-lg"></i> Tambah</button>
                            <!-- Modal Tambah Detail Pesanan -->
                            <div class="modal fade" id="tambahDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Detail Pesanan</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post"  enctype="multipart/form-data">
                                            <div class="modal-body">

                                                <!-- ID Pesanan -->
                                                <input type="hidden" class="form-control" name="id_pengguna" value="<?php echo $_SESSION['ID'];?>" readonly>

                                                <!-- Pilih Menu -->
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Pilih Menu</label>
                                                    <select class="form-select" name="id_menu" id="id_menu" required onchange="updateHarga()">
                                                        <option value="">-- Pilih Menu --</option>
                                                        <?php
                                                        $menu_query = $conn->query("SELECT * FROM menu WHERE ketersediaan = 'Tersedia'");
                                                        while ($menu = $menu_query->fetch_assoc()) {
                                                            echo '<option value="' . $menu['id_menu'] . '" data-harga="' . $menu['harga'] . '">';
                                                            echo '<img src="upload/menu/' . $menu['img'] . '" width="30px"> ';
                                                            echo $menu['nm_menu'] . ' - Rp ' . number_format($menu['harga'], 0, ',', '.');
                                                            echo '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <!-- Jumlah -->
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Jumlah</label>
                                                    <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required onkeyup="updateHarga()">
                                                </div>

                                                <!-- Harga & Subtotal -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Harga</label>
                                                            <input type="text" class="form-control" id="harga" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Subtotal</label>
                                                            <input type="text" class="form-control" id="subtotal" name="subtotal" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                        <?php
                                        require_once 'dbcon.php';

                                        if (isset($_POST['save'])) {
                                          if (isset($_POST['id_menu']) && isset($_POST['jumlah'])) {
                                              $id_pengguna = $_POST['id_pengguna'];
                                              $id_menu = $_POST['id_menu'];
                                              $jumlah = $_POST['jumlah'];

                                              // Ambil harga dari tabel menu
                                              $menu = $conn->query("SELECT harga FROM menu WHERE id_menu = '$id_menu'")->fetch_assoc();
                                              $harga = $menu['harga'];
                                              $subtotal = $harga * $jumlah;

                                              // Simpan ke detail_pesanan
                                              $conn->query("INSERT INTO detail_pesanan (id_pengguna, id_menu, jumlah, subtotal) VALUES ('$id_pengguna', '$id_menu', '$jumlah', '$subtotal')");
                                              echo "<script>window.location.href='pesan.php';</script>";
                                              exit();
                                          } else {
                                              echo "<script>alert('Data tidak lengkap'); window.history.back();</script>";
                                          }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Form untuk pesanan -->
                            <form method="post" enctype = "multipart/form-data">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama Menu</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            require 'dbcon.php';
                                            $no = 1;
                                            $total_harga = 0;

                                            // Ambil data pesanan
                                            $query = $conn->query("SELECT * FROM detail_pesanan dp JOIN menu m ON dp.id_menu = m.id_menu WHERE dp.id_pengguna = '$id_pengguna' and dp.id_pesanan IS NULL");
                                            while ($row = $query->fetch_assoc()) {
                                                $subtotal = $row['jumlah'] * $row['harga'];
                                                $total_harga += $subtotal;
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $no++; ?></th>
                                                <td><?php echo $row['nm_menu']; ?></td>
                                                <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                                <td><?php echo $row['jumlah']; ?></td>
                                                <td>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                                <td>
                                                  <input type="hidden" name="id_detail" value="<?php echo $row['id_detail'];?>">
                                                    <button name = "delete" type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>

                                                    <?php
                                                      require_once 'dbcon.php';

                                                      if(isset($_POST['delete'])){
                                                        $id_detail=$_POST['id_detail'];
                                                        $conn->query("delete from detail_pesanan where id_detail='$id_detail'") or die(mysql_error());
                                                        echo "<script> window.location='pesan.php' </script>";
                                                      }
                                                      ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                              <td colspan="4">
                                                <label for="total_harga" class="form-label">Total:</label>
                                              </td>
                                              <td colspan="2">
                                                <input type="text" class="form-control" id="total_harga" name="total_harga" value="Rp. <?php echo number_format($total_harga, 0, ',', '.'); ?>" readonly>
                                                <input type="hidden" class="form-control" id="total_harga" name="ttl_harga" value="<?php echo $total_harga; ?>" readonly>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="4">
                                                <label for="catatan_pemesanan" class="form-label">Catatan Pemesanan:</label>
                                              </td>
                                              <td colspan="2">
                                                <textarea class="form-control" id="catatan_pemesanan" name="catatan_pemesanan" rows="3"></textarea>
                                              </td>
                                            </tr>
                                            
                                            <tr>
                                              <td colspan="4">
                                                <label for="layanan" class="form-label">Pilih Layanan:</label>
                                              </td>
                                              <td colspan="2">
                                                <select class="form-select" id="layanan" name="layanan">
                                                  <option value="Dine In">Dine In</option>
                                                  <option value="Takeaway">Takeaway</option>
                                                  <option value="Delivery">Delivery</option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="4">
                                                <label for="metode_pembayaran" class="form-label">Pilih Metode Pembayaran:</label>
                                              </td>
                                              <td colspan="2">
                                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran">
                                                  <option value="Cash">Cash</option>
                                                  <option value="Transfer">Transfer</option>
                                                  <option value="E-Wallet">E-Wallet</option>
                                                </select>
                                              </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tombol Pesan -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" name="submit" class="btn btn-success">Pesan</button>
                                  </div>
                            </form>
                            <?php 
                              require 'dbcon.php';

                              if (isset($_POST['submit'])) {
                                  $id_pengguna = $_SESSION['ID']; // Pastikan session id_pengguna tersedia
                                  $catatan = $_POST['catatan_pemesanan'];
                                  $layanan = $_POST['layanan'];
                                  $metode_pembayaran = $_POST['metode_pembayaran'];
                                  $total_harga = $_POST['ttl_harga'];

                                  // 1. Masukkan ke tabel pesanan
                                  $insert_pesanan = $conn->query("INSERT INTO pesanan (id_pengguna, tanggal_pesan, total_harga, catatan, layanan, metode_pembayaran, status)
                                      VALUES ('$id_pengguna', CURRENT_TIMESTAMP(), '$total_harga', '$catatan', '$layanan', '$metode_pembayaran', 'Pending')");
                                  
                                  if ($insert_pesanan) {
                                      // Ambil id_pesanan terakhir yang dimasukkan
                                      $id_pesanan_baru = $conn->insert_id;

                                      // 2. Update detail_pesanan untuk menetapkan id_pesanan baru
                                      $update_detail = $conn->query("UPDATE detail_pesanan SET id_pesanan = '$id_pesanan_baru' WHERE id_pengguna = '$id_pengguna' and id_pesanan is null");
                                      $isi_notifikasi = "Pesanan baru telah dibuat dengan kode $id_pesanan_baru.";
                                                  
                                      $insert_notifikasi = $conn->query("INSERT INTO notifikasi (id_pengguna, id_pesanan, waktu_kirim, isi_notifikasi,status)
                                          VALUES ('1', '$id_pesanan_baru', CURRENT_TIMESTAMP(), '$isi_notifikasi','Unread')");
                                      if ($update_detail) {
                                          echo "<script>alert('Pesanan berhasil dibuat!'); window.location='pesan.php'</script>";
                                      } else {
                                          echo "<script>alert('Gagal update detail pesanan: " . $conn->error . "'); window.location='pesan.php'</script>";
                                      }
                                  } else {
                                      echo "<script>alert('Gagal membuat pesanan: " . $conn->error . "'); window.location='pesan.php'</script>";
                                  }
                              }
                              ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <?php include('footer.php'); ?>
    <script>
    function updateHarga() {
        var select = document.getElementById("id_menu");
        var selectedOption = select.options[select.selectedIndex];
        var harga = parseFloat(selectedOption.getAttribute("data-harga")) || 0;
        var jumlah = parseInt(document.getElementById("jumlah").value) || 0;

        var subtotal = harga * jumlah;

        document.getElementById("harga").value = "Rp " + harga.toLocaleString('id-ID');
        document.getElementById("subtotal").value = "Rp " + subtotal.toLocaleString('id-ID');
    }
    </script>
    <?php include('script.php'); ?>
</body>
</html>