<?php
	session_start();

	if (!isset($_SESSION['loggedin'])) {
		header('Location: index.html');
		exit;
	}

	include("../koneksi.php");

	$stmt = $con->prepare('SELECT first_name, last_name, gender, nomer_telp, alamat, email FROM users WHERE id = ?');
	$stmt->bind_param('i', $_SESSION['id']);
	$stmt->execute();
	$stmt->bind_result($first_name, $last_name,$gender,$nomer_telp,$alamat,$email);
	$stmt->fetch();
	$stmt->close();

	$user_id = htmlspecialchars($_SESSION['id']);

	$query = mysqli_query($con, "SELECT * FROM transaksi WHERE user_id = $user_id ");
	$jumlahProduk = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
	<link rel="Stylesheet" href="../styles.css" />
	<link rel="Stylesheet" href="profile.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="loggedin">
		<nav>
			<div class="logo">
				<img src="../images/navLogo.svg">
			</div>

			<ul>
				<li><a href="../homepage.php">Home</a></li>
				<li><a href="../collections.php">Collection</a></li>
				<li><a href="../about_us.php">About Us</a></li>
				<div class="accCart">
					<li><img src="../images/account_icon.png" style="height: 25px;"><a href="index.html">Login</a></li>
					<li><img src="../images/cart_icon.png" style="height: 25px;"><a href="#">Cart</a></li>
				</div>
			</ul>

			<div class="menu-toggle">
				<input type="checkbox" name="" id="" />
				<span></span>
				<span></span>
				<span></span>
			</div>
		</nav>	

		<nav class="navtop">
			<div>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Nama Lengkap :</td>
						<td><?=htmlspecialchars($first_name, ENT_QUOTES) . " " . htmlspecialchars($last_name, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Alamat:</td>
						<td><?=htmlspecialchars($alamat, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Nomer Telepon:</td>
						<td><?=htmlspecialchars($nomer_telp, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Gender :</td>
						<td><?=htmlspecialchars($gender, ENT_QUOTES)?></td>
					</tr>
				</table>
			</div>
		</div>

		<h2>Riwayat Pemesanan</h2>
		<table border="1">
    <thead>
        <tr>
            <th>ID Transaksi</th>
            <th>Total Bayar</th>
            <th>Waktu Transaksi</th>
            <th>Alamat Pengiriman</th>
            <th>Status Pembayaran</th>
        </tr>
    </thead>
    	<tbody>
                <?php
                if ($jumlahProduk == 0) {
                ?>
                    <tr>
                        <td colspan="11">Tidak ada data</td>
                    </tr>

                    <?php
                } else {
                    $jumlah = 1;
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $data['order_id']; ?></td>
                            <td><?php echo $data['total_harga']; ?></td>
                            <td><?php echo $data['waktu_transaksi']; ?></td>
                            <td><?php echo $data['alamat_pengiriman']; ?></td>
                            <td><?php echo $data['status_pembayaran']; ?></td>
                        </tr>
                <?php
                        $jumlah++;
                    }
                }
                ?>
            </tbody>
</table>

	</body>
</html>




