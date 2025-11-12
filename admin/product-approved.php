<?php
include '../config/db_connect.php';
$id = $_GET['id'];

$query = mysqli_query($conn,"UPDATE `products` SET `product_status`='Approved' WHERE 1");

if($query){
    echo "<script>
        alert('Tester assigned successfully!');
        window.location.href='view-products.php';
      </script>";
}


?>