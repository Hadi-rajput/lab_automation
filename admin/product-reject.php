<?php
include '../config/db_connect.php';

$idtoberej = $_GET['id'];

$query = mysqli_query($conn,"UPDATE `products` SET `product_status`='Rejected', `review`='fail' WHERE product_id = $idtoberej");

if($query){
    echo "<script>
    alert('Product has been rejected successfully!');
    window.location.href = 'view-products.php';
</script>";
}


?>