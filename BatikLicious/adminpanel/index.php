<?php
session_start();

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['name'] !== 'admin') {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../phplogin/"); // Ganti login.php dengan halaman login Anda
    exit; // Pastikan kode di bawah tidak dijalankan setelah redirect
}

include('../koneksi.php');

$query = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatikLicious</title>
    <link rel="Stylesheet" href="styles-admin.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="../images/navLogo.svg">
        </div>

        <ul>
            <li><a href="../homepage.php">Home</a></li>
            <li><a href="../collections.php">Collection</a></li>
            <li><a href="../about_us.php">About Us</a></li>
            <div class="../accCart">
                <li><img src="../images/account_icon.png" style="height: 25px;"><a href="account.html">Account</a></li>
                <li><img src="../images/cart_icon.png" style="height: 25px;"><a href="#">Cart</a></li>
            </div>
        </ul>

        <div class="menu-toggle">
            <input type="checkbox" name="" id="" />
              <span></span>
              <span></span>
              <span></span>
    </nav>
    <div class="container">
        <h2>Daftar Produk</h2>
        <p>Jumlah Produk = <?php echo $jumlahProduk ?></p>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Ketersediaan Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($jumlahProduk == 0) {
                ?>
                    <tr>
                        <td colspan="6">Tidak ada data</td>
                    </tr>

                    <?php
                } else {
                    $jumlah = 1;
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td>
                            <div class="produkNama">
                                <img src="../images/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama']; ?>" width="60">
                                <p><?php echo $data['nama']; ?></p>
                            </div>
                            </td>
                            <td><?php echo $data['harga']; ?></td>
                            <td><?php echo $data['ketersediaan_stok']; ?></td>
                            <td>
                                <a href="updateProduk.php?id=<?php echo $data['id']; ?>" class="btn update-btn">Update</a>
                                <a href="deleteProduk.php?id=<?php echo $data['id']; ?>" class="btn delete-btn">Delete</a>
                            </td>
                        </tr>
                <?php
                        $jumlah++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
        <div class="button-container">
            <button class="btn" onclick="window.location.href='tambahProduk.php'">Tambahkan Produk</button>
        </div>
    </div>
</body>
</html>