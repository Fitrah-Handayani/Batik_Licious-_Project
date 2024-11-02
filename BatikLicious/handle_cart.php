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

// Ambil detail produk dari formulir
$product_id = $_POST['product_id'];
$nama_produk = $_POST['nama_produk'];
$ukuran = $_POST['ukuran'];
$jumlah = $_POST['jumlah'];
$action = $_POST['action'];

// Periksa apakah produk sudah ada di keranjang
$checkCart = mysqli_query($con, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND size='$ukuran'");
if (mysqli_num_rows($checkCart) > 0) {
    // Jika produk sudah ada di keranjang, perbarui jumlahnya
    $updateCart = mysqli_query($con, "UPDATE cart SET quantity = quantity + '$jumlah' WHERE user_id='$user_id' AND product_id='$product_id' AND size='$ukuran'");
} else {
    // Jika produk belum ada di keranjang, tambahkan baris baru
    $stmt = $con->prepare("INSERT INTO cart (user_id, product_id, quantity, size, nama_produk) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $user_id, $product_id, $jumlah, $ukuran, $nama_produk);
    $stmt->execute();
}

if ($action == 'checkout') {
    // Arahkan ke halaman checkout
    header('Location: checkout.php?nama=' . $nama_produk . '&jumlah=' . $jumlah . '&ukuran=' . $ukuran);
} else {
    echo "<script>alert('Berhasil Memasukkan ke Keranjang');</script>";
    echo "<p>Redirecting...</p>";
    echo "<script>setTimeout(function(){ window.location.href = 'detail.php?nama=" . urlencode($nama_produk) . "'; }, 20);</script>";
}
exit();

?>