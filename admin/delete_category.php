<?php
include "../config/db_connect.php";

$idtobedeleted = $_GET['id'];

$delquery = mysqli_query($conn,"DELETE FROM `categories` WHERE categories_id = $idtobedeleted");

if($delquery){
    echo "
    <script>
        alert('category deleted successfully!');
        window.location.href = 'view-categories.php';
    </script>
    ";
}


?>