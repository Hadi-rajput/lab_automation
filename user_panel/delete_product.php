<?php
include '../config/db_connect.php';
$idtobedel = $_GET['id'];

$del = mysqli_query($conn,"DELETE FROM `products` WHERE product_id = $idtobedel");

if($del){
     echo "
            <script>
                alert('Product Deleted Successfully!');
                window.location.href = 'pending_products.php';
            </script>
            ";
}


?>