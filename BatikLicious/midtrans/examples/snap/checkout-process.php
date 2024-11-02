<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap popup:
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

namespace Midtrans;

require_once dirname(__FILE__) . '/../../Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-YfcoAosFn0NqWuZfaPlgc_m5';
Config::$clientKey = 'SB-Mid-client-7ejTf4L1qGm2Otzu';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;

// Uncomment for append and override notification URL
// Config::$appendNotifUrl = "https://example.com";
// Config::$overrideNotifUrl = "https://example.com";

    include "../../../koneksi.php";

    session_start();

    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['loggedin'])) {
        header('Location: phplogin/index.html');
        exit();
    }


    // Dapatkan ID pengguna dari sesi
    $user_id = $_SESSION['id'];
    $total = $_GET['total'];

    $order_id = $_GET['order_id'];
    $alamat_pengiriman = $_POST['alamat_pengiriman'];
    // Simpan transaksi ke dalam database dengan order_id
    $queryInsertTransaction = mysqli_query($con, "INSERT INTO transaksi (user_id, order_id, total_harga,alamat_pengiriman) VALUES ('$user_id', '$order_id', '$total', '$alamat_pengiriman')");

    $query = "SELECT * FROM transaksi 
              INNER JOIN cart ON transaksi.user_id = cart.user_id 
              INNER JOIN produk ON cart.product_id = produk.id
              WHERE order_id = '".$order_id."' ";
    $sql = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($sql);
    

    $user_id = $data['user_id'];
// Required
$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => $data['total_harga'], 
);

$query = "SELECT * FROM cart INNER JOIN produk ON cart.product_id = produk.id WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$item_details = array();
while ($row = mysqli_fetch_assoc($result)) {
    $item_details[] = array(
        'id' => $row['product_id'],
        'price' => $row['harga'],
        'quantity' => $row['quantity'],
        'name' => $row['nama']
    );
}


$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_array($result);

// Optional
$billing_address = array(
    'first_name'    => $data['first_name'],
    'last_name'     => $data['last_name'],
    'address'       => $data['alamat'],
    'phone'         => $data['nomer_telp'],
    'country_code'  => 'IDN'
);

// Optional
$shipping_address = array(
    'first_name'    => $data['first_name'],
    'last_name'     => $data['last_name'],
    'address'       => $alamat_pengiriman,
    'phone'         => $data['nomer_telp'],
    'country_code'  => 'IDN'
);

// Optional
$customer_details = array(
    'first_name'    => $data['first_name'],
    'last_name'     => $data['last_name'],
    'email'         => $data['email'],
    'phone'         => $data['nomer_telp'],
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);



// Fill transaction details
$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
}
catch (\Exception $e) {
    echo $e->getMessage();
}


function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    } 
}

?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Style for the button */
        .back-to-collections {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        /* Hover effect */
        .back-to-collections:hover {
            background-color: #45a049;
        }

        /* Style for the payment button */
        .payment-button {
            display: inline-block;
            padding: 15px 25px;
            background-color: #ff6600;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        /* Hover effect */
        .payment-button:hover {
            background-color: #e65c00;
            transform: translateY(-2px);
        }

        /* Active effect */
        .payment-button:active {
            background-color: #cc5200;
            transform: translateY(0);
        }


    </style>
</head>
    <body>
        <button id="pay-button" class="payment-button">Pilih Metode Pembayaran!</button> 
        <div class="result-message-succes">
            <p id="result-message" class="result-message"></p>;
        </div>
        <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
        <script type="text/javascript">
            
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('<?php echo $snap_token?>', {
                    // Optional
                    onSuccess: function(result){
                        window.location.href = '../../../nota/index.php?order_id=<?php echo $order_id?>';
                    },
                    // Optional
                    onPending: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            };
        </script>
    </body>
</html>
