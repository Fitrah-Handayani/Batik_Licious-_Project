<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

require "../koneksi.php";

$id = $_GET['id']; 

$query = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
$data = mysqli_fetch_array($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $ketersediaan_stok = $_POST['ketersediaan_stok'];
    $deskripsi = $_POST['deskripsi'];

    $target_dir = "../images/";
    $foto1_name = $data['foto'];
    $foto2_name = $data['foto2'];

    // Handle foto1
    if (!empty($_FILES["foto"]["name"])) {
        $foto1_name = basename($_FILES["foto"]["name"]);
        $foto1_target = $target_dir . $foto1_name;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $foto1_target)) {
            echo "Foto 1 berhasil diupload.<br>";
        } else {
            echo "Gagal mengupload foto 1.<br>";
        }
    }

    // Handle foto2
    if (!empty($_FILES["foto2"]["name"])) {
        $foto2_name = basename($_FILES["foto2"]["name"]);
        $foto2_target = $target_dir . $foto2_name;
        if (move_uploaded_file($_FILES["foto2"]["tmp_name"], $foto2_target)) {
            echo "Foto 2 berhasil diupload.<br>";
        } else {
            echo "Gagal mengupload foto 2.<br>";
        }
    }

    // Check if the new nama_produk exists in the cart table to avoid constraint violation
    $checkSql = "SELECT COUNT(*) as count FROM cart WHERE nama_produk='$nama'";
    $result = mysqli_query($con, $checkSql);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        // Update the cart table to reflect the new product name
        $updateCartSql = "UPDATE cart SET nama_produk='$nama' WHERE nama_produk='{$data['nama']}'";
        if (!mysqli_query($con, $updateCartSql)) {
            echo "<script>alert('Gagal Mengupdate Cart Produk');</script>";
            exit;
        }
    }

    // Update the produk table
    $updateQuery = "UPDATE produk SET 
                    nama='$nama', 
                    harga='$harga', 
                    foto='$foto1_name', 
                    ketersediaan_stok='$ketersediaan_stok', 
                    deskripsi='$deskripsi', 
                    foto2='$foto2_name' 
                    WHERE id='$id'";

    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo "<script>alert('Produk Berhasil Diupdate!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 0);</script>";
    } else {
        echo "<script>alert('Gagal Mengupdate Produk');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Produk</title>
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
            <div class="accCart">
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
        <h2>Update Produk</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post" enctype="multipart/form-data">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>"><br><br>

            <label for="harga">Harga:</label>
            <input type="text" id="harga" name="harga" value="<?php echo $data['harga']; ?>"><br><br>

            <label for="foto">Foto 1:</label>
            <input type="file" name="foto" id="foto">
            <?php if (!empty($data['foto'])) { echo "<p>File sebelumnya: {$data['foto']}</p>"; } ?>
            <br><br>

            <label for="foto2">Foto 2:</label>
            <input type="file" name="foto2" id="foto2">
            <?php if (!empty($data['foto2'])) { echo "<p>File sebelumnya: {$data['foto2']}</p>"; } ?>
            <br><br>

            <label for="ketersediaan_stok">Ketersediaan Stok:</label>
            <select id="ketersediaan_stok" name="ketersediaan_stok">
                <option value="Tersedia" <?php if ($data['ketersediaan_stok'] == 'Tersedia') echo 'selected'; ?>>Tersedia</option>
                <option value="Habis" <?php if ($data['ketersediaan_stok'] == 'Habis') echo 'selected'; ?>>Habis</option>
            </select><br><br>
            
            <label for="deskripsi">Deskripsi:</label>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $data['deskripsi']; ?>"><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
