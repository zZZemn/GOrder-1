<?php
include("../database/db.php");

$quantity = $_POST['quantity'];
$product_id = $_POST['productId'];

$product_query = "SELECT * FROM tblproducts WHERE product_code = $product_id";
$product_query_result = $conn->query($product_query);
$product = $product_query_result->fetch_assoc();

$amt = $product['selling_price'] * $quantity;

// Update the quantity for the specified product ID in the database
$sql = "UPDATE tblpos_cur_process SET qty = '$quantity', amount = '$amt' WHERE product_code = '$product_id'";

if (mysqli_query($conn, $sql)) 
{
    echo $amt;
} else 
{
  echo "Error updating quantity: " . mysqli_error($conn);
}
?>
