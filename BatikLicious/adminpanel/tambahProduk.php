<?php
require "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $ketersediaan_stok = $_POST['ketersediaan_stok'];
    $deskripsi = $_POST['deskripsi'];

    $target_dir = "../images/";

    // Handle foto1
    $foto1_name = basename($_FILES["foto"]["name"]);
    $foto1_target = $target_dir . $foto1_name;
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $foto1_target)) {
        echo "Foto 1 berhasil diupload.<br>";
    } else {
        echo "Gagal mengupload foto 1.<br>";
    }

    // Handle foto2
    $foto2_name = basename($_FILES["foto2"]["name"]);
    $foto2_target = $target_dir . $foto2_name;
    if (move_uploaded_file($_FILES["foto2"]["tmp_name"], $foto2_target)) {
        echo "Foto 2 berhasil diupload.<br>";
    } else {
        echo "Gagal mengupload foto 2.<br>";
    }

    // Insert into database
    $insertQuery = "INSERT INTO produk (nama, harga, foto, ketersediaan_stok, deskripsi, foto2) 
                    VALUES ('$nama', '$harga', '$foto1_name', '$ketersediaan_stok', '$deskripsi', '$foto2_name')";
    $result = mysqli_query($con, $insertQuery);

    if ($result) {
        header('Location: index.php');
    } else {
        echo "<script>alert('Gagal Menambahkan Produk');</script>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="styles-admin.css">
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

    <div class="form-tambah_produk">
        <h2>Tambah Produk</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama"><br><br>
            <label for="harga">Harga:</label>
            <input type="text" id="harga" name="harga"><br><br>
            <label for="foto">Foto 1:</label>
            <input type="file" name="foto" id="foto"><br><br>
            <label for="foto2">Foto 2:</label>
            <input type="file" name="foto2" id="foto2"><br><br>
            <label for="ketersediaan_stok">Ketersediaan Stok:</label>
            <input type="text" id="ketersediaan_stok" name="ketersediaan_stok"><br><br>
            <label for="deskripsi">Deskripsi:</label>
            <input type="text" id="deskripsi" name="deskripsi"><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
