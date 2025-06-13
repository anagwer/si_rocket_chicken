<?php
session_start();

// Jika sudah login, arahkan ke halaman utama
if (isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit();
}

include_once('dbcon.php');

$errorMsg = "";

if (isset($_POST['submit'])) {
    $nama       = $conn->real_escape_string($_POST['nama']);
    $username   = $conn->real_escape_string($_POST['username']);
    $password   = md5($conn->real_escape_string($_POST['password'])); 
    $no_telp    = $conn->real_escape_string($_POST['no_telp']);

    // Validasi form tidak boleh kosong
    if (empty($nama) || empty($username) || empty($password) || empty($no_telp)) {
        $errorMsg = "Semua kolom harus diisi!";
    } else {
        // Cek apakah username sudah ada
        $checkUser = "SELECT * FROM pengguna WHERE username = '$username'";
        $result = $conn->query($checkUser);

        if ($result->num_rows > 0) {
            $errorMsg = "Username sudah digunakan!";
        } else {
            // Masukkan pengguna baru
            $sql = "INSERT INTO pengguna (nama, no_telp, username, password, role)
                    VALUES ('$nama', '$no_telp', '$username', '$password', 'pelanggan')";

            if ($conn->query($sql) === TRUE) {
                // Redirect ke halaman login
                header("Location: login.php");
                exit();
            } else {
                $errorMsg = "Gagal mendaftarkan akun. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sistem Pemesanan Quick Chicken</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            
            <div class="col-lg-6">
              <div class="card">

                <div class="card-body">
                <div class="col-lg-12 col-md-6 pt-4 text-center">
                  <div class="pt-2 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Daftar</h5>
                  </div>
                </div>
                  <?php if (!empty($errorMsg)) { ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php echo $errorMsg; ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  <?php } ?>
                  <form class="row g-3 needs-validation" method="POST" action="">

                    <div class="col-12">
                      <div class="input-group has-validation">
                        <input type="text" name="nama" class="form-control" id="yourUsername"  placeholder="Masukkan Nama" required>
                        <div class="invalid-feedback">Please enter your nama.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="yourUsername"  placeholder="Masukkan username" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="input-group has-validation">
                      <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Masukkan password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                      </div>
                    </div>

                   <div class="col-12 input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telepon" required>
                  </div>
                    <span> Sudah punya akun? <a href="login.php">Login disini</a></span>
                     <div class="col-6">
                    <input type="submit" name="submit" class="btn btn-primary w-100" value="Daftar">
                    </div>
                    <div class="col-6">
                    <a href="login.php" class="btn btn-danger w-100">Back</a>
                    </div>
                    
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>