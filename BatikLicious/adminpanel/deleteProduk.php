<?php
include('../koneksi.php');

$id = $_GET['id'];

// Delete related records in the cart table
$query_cart = mysqli_query($con, "DELETE FROM cart WHERE product_id='$id'");

// Delete the product from the produk table
$query = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

if ($query) {
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}

?>