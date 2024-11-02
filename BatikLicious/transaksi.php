<?php 
require "koneksi.php";
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin'])) {
    header('Location: phplogin/index.html');
    exit();
}

$total = $_GET['total'];

// Dapatkan ID pengguna dari sesi
$user_id = $_SESSION['id'];



// Simpan transaksi ke dalam database dengan order_id
$queryInsertTransaction = mysqli_query($con, "INSERT INTO transaksi (user_id, order_id, total_harga) VALUES ('$user_id', '$order_id', '$total')");
    echo "<script>setTimeout(function(){ window.location.href = 'http://localhost/batiklicious/midtrans/examples/snap/index.php?order_id=$order_id'; }, 2);</script>";
?>