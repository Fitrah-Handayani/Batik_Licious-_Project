<?php
  $base = $_SERVER['REQUEST_URI'];

  require "../../../koneksi.php";
  session_start();

  // Periksa apakah pengguna sudah login
  if (!isset($_SESSION['loggedin'])) {
      header('Location: ../../../phplogin/index.html');
      exit();
  }

  // Dapatkan ID pengguna dari sesi
  $user_id = $_SESSION['id'];

  // Ambil data keranjang dari database
  $queryCart = mysqli_query($con, "SELECT cart.*, produk.nama, produk.harga, produk.foto FROM cart JOIN produk ON cart.product_id = produk.id WHERE cart.user_id = '$user_id'");
  $query = mysqli_query($con, "SELECT * FROM transaksi WHERE user_id = '$user_id'");
  $data = mysqli_fetch_array($query);

  $order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h3 {
            text-align: center;
            color: #50413d;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #50413d;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            border-radius: 5px;
        }
        h4 {
            text-align: center;
            color: #50413d;
        }
        .checkout-form {
            text-align: center;
            margin-top: 20px;
        }
        .checkout-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #50413d;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .checkout-form input[type="submit"]:hover {
            background-color: #218838;
        }

        .checkout-form input[type="submit"]:hover {
            background-color: #218838;
        }
        .checkout-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #50413d;
        }
        .checkout-form input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .produkNama {
            display: flex;
            gap: 20px;
            align-items: center;
        }
    </style>
</head>
<body>
    <h3>Produk Yang Dipilih : </h3>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            while ($cartItem = mysqli_fetch_array($queryCart)) {
                $subtotal = $cartItem['harga'] * $cartItem['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td>
                    <div class="produkNama">
                        <img src="../../../images/<?php echo $cartItem['foto']; ?>" alt="<?php echo $cartItem['nama']; ?>" width="60">
                        <p><?php echo $cartItem['nama']; ?></p>
                    </div>
                </td>
                <td><?php echo $cartItem['size']; ?></td>
                <td><?php echo $cartItem['quantity']; ?></td>
                <td>Rp.<?php echo $cartItem['harga']; ?></td>
                <td>Rp.<?php echo $subtotal; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <h4>Total: Rp.<?php echo $total ?></h4>
    <div class="checkout-form">
        <form action="checkout-process.php?order_id=<?php echo $order_id;?>&total=<?php echo $total; ?>" method="POST">
            <label for="alamat_pengiriman">Alamat Pengiriman</label>
            <input type="text" id="alamat_pengiriman" name="alamat_pengiriman" required>

            <input type="submit" value="Confirm">
        </form>
    </div>
</body>
</html>
