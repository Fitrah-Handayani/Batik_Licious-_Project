<?php 
require "koneksi.php";

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: phplogin/index.html');
    exit;
}

$order_id = "ORD" . date("YmdHis");

// Simpan transaksi ke dalam database dengan order_id
$queryInsertTransaction = mysqli_query($con, "INSERT INTO transaksi (user_id, order_id, total_harga) VALUES ('$user_id', '$order_id', '$total')");
    echo "<script>alert('Lanjutkan Ke Metode Pembayaran?');</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'http://localhost/batiklicious/midtrans/examples/snap/checkout-process.php?order_id=$order_id'; }, 2000);</script>";

?>    
