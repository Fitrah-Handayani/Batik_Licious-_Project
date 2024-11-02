<?php 
include('../koneksi.php');

$order_id = $_GET['order_id'];

// Fetch the transaction details
$query = "SELECT transaksi.*, users.first_name, users.last_name FROM transaksi 
INNER JOIN users ON transaksi.user_id = users.id 
WHERE transaksi.order_id = '$order_id'";
$sql = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($sql);

if ($data) {
    $user_id = $data['user_id'];

    // Fetch the cart details
    $query = "SELECT produk.nama AS nama_produk, produk.harga, cart.size, cart.quantity FROM cart 
    INNER JOIN produk ON cart.product_id = produk.id 
    WHERE cart.user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    $item_details = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "No transaction found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran BatikLicious</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .invoice {
            background-color: #fff;
            padding: 20px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .invoice-info {
            text-align: left;
        }
        .invoice-logo {
            text-align: right;
        }
        .invoice-customer {
            margin-bottom: 20px;
        }
        .invoice-items {
            border-collapse: collapse;
            width: 100%;
        }
        .invoice-items th,
        .invoice-items td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .invoice-items th {
            text-align: left;
            background-color: #f0f0f0;
        }
        .invoice-footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pembayaran Berhasil!</h1>
        <p>Terima kasih! Pembayaran Anda sudah diterima. Silakan lihat detail pesanan Anda di bawah ini:</p>

        <div class="invoice">
            <div class="invoice-header">
                <div class="invoice-info">
                    <p>Tanggal : <?php echo $data['waktu_transaksi']; ?></p>
                    <p>ID Pesanan: <?php echo $data['order_id']; ?></p>
                </div>
                <div class="invoice-logo">
                    <img src="../images/batikliciousLogo.svg" alt="Logo BatikLicious" width="180px" height="auto">
                </div>
            </div>
            <div class="invoice-customer">
                <p>Kepada : <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></p>
            </div>
            <div class="invoice-items">
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Quantity</th>
                            <th>Ukuran</th>
                            <th>Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item_details as $item): ?>
                        <tr>
                            <td><?php echo $item['nama_produk']; ?></td>
                            <td> <?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['size']; ?></td>
                            <td>IDR <?php echo $item['harga']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="3">Total Belanja</th>
                            <th>IDR <?php echo $data['total_harga']; ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="invoice-footer">
                <p>**Untuk informasi lebih lanjut, silakan hubungi tim support BatikLicious via e-mail batiklicious9@gmail.com atau telepon +6285943803855.**</p>            </div>
        </div>
    </div>
</body>
</html>
