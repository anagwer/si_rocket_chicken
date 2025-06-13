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
                            <h5 class="card-title">Data Menu</h5>
                            <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="bi bi-plus-lg"></i> Tambah</button>
                            <?php include('add_menu.php'); 
                            endif;?>
                            <hr>
                            <!-- Table with stripped rows -->
                             
                            <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Nama Menu</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Ketersediaan</th>
                                        <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                                        <th scope="col">Aksi</th>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        require 'dbcon.php';
                                        $no = 1;
                                        $bool = false;
                                        $query = $conn->query("SELECT * FROM menu ORDER BY id_menu DESC");
                                        while ($row = $query->fetch_array()) {
                                            $id_menu = $row['id_menu'];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $no++; ?></th>
                                        <td><img src="upload/menu/<?php echo $row['img'];?>" style="width:150px; height:auto;"></td>
                                        <td><?php echo $row['nm_menu']; ?></td>
                                        <td><?php echo $row['deskripsi']; ?></td>
                                        <td><?php echo 'Rp. '.number_format($row['harga'], 0, ",", ".");?></td>
                                        <td>
                                            <?php if ($row['ketersediaan'] == "Tersedia"): ?>
                                                <span class="badge bg-success">Tersedia</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Kosong</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                                        <td style="text-align:center">
                                            <a rel="tooltip" title="Edit" id="<?php echo $row['id_menu'] ?>" href="#edit_menu<?php echo $row['id_menu'];?>" data-toggle="modal" class="btn btn-success btn-outline"><i class="bi bi-pencil-square"></i> </a>
                                            <a rel="tooltip" title="Delete" id="<?php echo $row['id_menu'] ?>" href="#delete_menu<?php echo $row['id_menu'];?>" data-toggle="modal" class="btn btn-danger btn-outline"><i class="bi bi-trash-fill"></i> </a>
                                        </td>
                                        <?php endif;?>
                                    </tr>
                                    <?php
                                        require 'edit_menu.php';
                                        require 'delete_menu.php';
                                        } 
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
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