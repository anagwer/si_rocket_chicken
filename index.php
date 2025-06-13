<?php include ('session.php');?>
<?php include ('head.php');?>


<body>
    <!-- Navigation -->
    <?php include ('side_bar.php');?>

  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row"><?php 
           $hasil =date('Y');?>
        <!-- Left side columns -->
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah Menu<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM menu");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah Pengguna<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM pengguna");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah Pesanan Selesai<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM pesanan where status='Selesai'");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah Pesanan Berjalan<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM pesanan where status NOT LIKE '%Selesai%'");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        
  </main><!-- End #main -->

  <?php include ('footer.php');?>
      <?php include ('script.php');?>
      
</body>

</html>