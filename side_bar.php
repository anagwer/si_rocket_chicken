<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">Sisanket</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        
    </div><!-- End Logo -->

    
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <?php
                $id_pengguna = $_SESSION['ID'];

                // Ambil notifikasi dari database
                
                $query = $conn->query("SELECT COUNT(*) as jml FROM notifikasi where id_pengguna = $id_pengguna and status='Unread'");
                $row = $query->fetch_array();
                $jml = $row['jml'];
                ?>
            <!-- Notification Icon -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <?php if ($jml > 0): ?>
                        <span class="badge bg-primary badge-number"><?= $jml ?></span>
                    <?php endif; ?>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        Kamu memiliki <?= $jml ?> notifikasi
                        <a href="notifikasi.php"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat Semua</span></a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <?php if ($jml > 0): ?>
                        <?php 
                            $notifQuery = $conn->query("SELECT * FROM notifikasi WHERE id_pengguna = $id_pengguna ORDER BY Waktu_Kirim DESC LIMIT 5");
                            while ($notif = $notifQuery->fetch_array()) { ?>
                                <li class="notification-item d-flex align-items-start justify-content-between">
                                    <div class="d-flex align-items-start flex-grow-1">
                                        <?php if($notif['status']=='Unread'){?>
                                        <form method="post" class="me-3">
                                            <input type="hidden" name="id_notifikasi" value="<?= $notif['id_notifikasi'] ?>">
                                            <button class="btn text-success" name="updatenotif" type="submit">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                        <?php
                                        if (isset($_POST['updatenotif'])) {
                                            $id_notifikasi = $_POST['id_notifikasi'];
                                            $conn->query("UPDATE notifikasi SET status = 'Read' WHERE id_notifikasi = '$id_notifikasi'");
                                            echo "<script>window.location = window.location.href;</script>";
                                        }
                                        }
                                        ?>
                                        <div>
                                            <h6><?= htmlspecialchars($notif['isi_notifikasi']) ?></h6>
                                            <p class="small text-muted">
                                                <?= date('d M H:i', strtotime($notif['waktu_kirim'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            <?php } ?>
                    <?php else: ?>
                        <li class="notification-item">
                            <p class="text-center text-muted">Tidak ada notifikasi</p>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>

                    
                </ul>
            </li>
            <!-- End Notification Nav -->

            <!-- Profile Nav -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle rounded-circle" style="margin-right:10px;font-size:30px;"></i>
                    <span><?php echo $_SESSION['NAMA']; ?></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $_SESSION['NAMA']; ?></h6>
                        <span><?php echo $_SESSION['ROLE']; ?></span>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="profil.php">
                            <i class="bi bi-gear"></i>
                            <span>Setting Profil</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav>
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
<?php 
    // Get current page name
    $current_page = basename($_SERVER['PHP_SELF']); 
?>
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- mulai sidebar biasa -->
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'index.php' ? '' : 'collapsed'; ?>" href="index.php">
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'menu.php' ? '' : 'collapsed'; ?>" href="menu.php">
                <span>Menu</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'pesan.php' ? '' : 'collapsed'; ?>" href="pesan.php">
                <span>Pesan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'pesanan.php' ? '' : 'collapsed'; ?>" href="pesanan.php">
                <span>Data Pesanan</span>
            </a>
        </li>
        <?php if($_SESSION['ROLE']=='Admin'){?>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'pengguna.php' ? '' : 'collapsed'; ?>" href="pengguna.php">
                <span>Pengguna</span>
            </a>
        </li>
            <?php }?>
        <li class="nav-item">
          <a href="#" class="nav-link <?php echo $current_page == 'logout.php' ? '' : 'collapsed'; ?>" data-toggle="modal" data-target="#myModal1"> Logout</a>
        </li><!-- End Data User Nav -->
    </ul>
    
</aside><!-- End Sidebar -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="logout.php" enctype="multipart/form-data">    
                    Apakah anda yakin akan keluar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button name="save" type="submit" class="btn btn-primary">Ya</button>
                </form>  
            </div>
        </div>
    </div>
</div>