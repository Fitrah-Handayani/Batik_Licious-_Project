<?php
require "koneksi.php";
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin'])) {
    header('Location: phplogin/index.html');
    exit();
}

// Dapatkan ID pengguna dari sesi
$user_id = $_SESSION['id'];

// Ambil ID item keranjang dari formulir
$cart_id = $_POST['cart_id'];

// Hapus item dari keranjang
$removeItem = mysqli_query($con, "DELETE FROM cart WHERE id='$cart_id' AND user_id='$user_id'");

// Periksa apakah penghapusan berhasil
if ($removeItem) {
    // Jika berhasil, kembali ke halaman keranjang
    header('Location: cart.php');
    exit();
} else {
    // Jika gagal, tampilkan pesan kesalahan
    echo "Gagal menghapus item dari keranjang.";
}
?>
