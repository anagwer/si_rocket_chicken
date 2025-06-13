<?php

session_start();
// Include database connection file
include_once('dbcon.php');

if (!isset($_SESSION['ID'])) {
    header("Location:login.php");
    exit();
}
?>
<?php 
    $session_id=$_SESSION['ID'];
    $user_query = $conn->query("SELECT * FROM pengguna WHERE id_pengguna = '$session_id'") or die(mysqli_errno());
    $user_row = $user_query->fetch_array();
    $user_name = $user_row['username'];
?>