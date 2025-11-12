<?php
include '../config/db_connect.php';

$product_id = $_GET['product_id'];
$tester_id = $_GET['tester_id'];

mysqli_query($conn, "UPDATE products 
                     SET assigned_tester_id='$tester_id' 
                     WHERE product_id='$product_id'");

header("Location: view-products.php");
exit;
?>
