<?php 
require "koneksi.php";

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: phplogin/index.html');
    exit;
}

$nama = htmlspecialchars($_GET['nama']);
$jumlah = htmlspecialchars($_GET['jumlah']);
$ukuran = htmlspecialchars($_GET['ukuran']);

$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

$query = mysqli_query($con, "SELECT * FROM produk
                    INNER JOIN kategori ON produk.kategori_id = kategori.kategori_id
                    ORDER BY RAND()");
$jumlahProduk = mysqli_num_rows($query);

$stmt = $con->prepare('SELECT first_name, last_name, gender, nomer_telp, alamat, email FROM users WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $gender, $nomer_telp, $alamat, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="checkout.css"> 
</head>
<body>
    <form action="confirm-checkout.php" method="post" enctype="multipart/form-data">
        <h2>Detail Pembayaran</h2>

        <label for="nama_produk">Nama Produk</label>
        <input type="text" id="nama_produk" name="nama_produk" value="<?= htmlspecialchars($produk['nama']) ?>" readonly>

        <label for="harga">Harga</label>
        <input type="text" id="harga" name="harga" value="<?= $produk['harga'] ?>" readonly>

        <label for="jumlah">Jumlah</label>
        <input type="text" id="jumlah" name="jumlah" value="<?= $jumlah ?>" readonly>

        <label for="ukuran">Ukuran</label>
        <input type="text" id="ukuran" name="ukuran" value="<?= $ukuran ?>" readonly>
        
        <label for="Total_Bayar">Total Bayar</label>
        <input type="text" id="Total_Bayar" name="Total_Bayar" value="<?= $produk['harga'] * $jumlah ?>" readonly>

        <label for="alamat">Alamat Pengiriman</label>
        <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($alamat) ?>">

        <input type="submit" value="Submit" name="submit">
    </form>
</body>
</html>
