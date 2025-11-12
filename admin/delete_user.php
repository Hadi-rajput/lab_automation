<?php
include '../config/db_connect.php';


$idtobedeleted = $_GET['id'];

mysqli_query($conn, "DELETE FROM products WHERE user_id = '$idtobedeleted'");

$imageq = mysqli_query($conn,"SELECT user_image FROM users WHERE user_id = $idtobedeleted");
$olduseriamge = mysqli_fetch_assoc($imageq);
$oldimagename = $olduseriamge['user_image'];
$oldpath = "userpfp/".$oldimagename;

if(file_exists($oldpath)){
    if(!@unlink($oldpath)){
        error_log("Failed to delete image: $oldpath");
    }
}

$deleteq = mysqli_query($conn,"DELETE FROM users WHERE user_id = '$idtobedeleted'");

if($deleteq){
    echo "
    <script>
        alert('User and related products deleted successfully!');
        window.location.href = 'view-users.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Error deleting user from database!');
    </script>
    ";
}
?>
