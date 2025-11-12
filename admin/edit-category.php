<?php
include 'header.php';


$idtobeupdated = $_GET['id'];

$alldata = mysqli_query($conn,"SELECT * from categories where categories_id = $idtobeupdated");
$categoriesdata = mysqli_fetch_assoc($alldata);

if(isset($_POST['btnadd'])){
    $name = $_POST['categoryname'];


    $query = mysqli_query($conn,"UPDATE `categories` SET `categories_name`='$name' WHERE categories_id = $idtobeupdated");

    if($query){
          echo "
    <script>
        alert('category updated successfully!');
        window.location.href = 'view-categories.php';
    </script>
    ";
    }
}



?>


<div class="container-fluid">

<h1 class="text-center text-primary fw-bolder mb-4" 
    style="font-size: 2.2rem; text-transform: uppercase; letter-spacing: 1px;">
    Add Category
    <span class="text-secondary fw-normal" style="font-size: 1.2rem;"> | Control Panel</span>
</h1>



    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow mb-5">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-primary">Add User Below</h6>
                </div>
                <div class="card-body">

                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group mb-3">
                            <label for="productName" class="fw-semibold text-dark">Category Name</label>
                            <input type="text" class="form-control" name="categoryname" value="<?php echo $categoriesdata['categories_name']?>" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5 fw-semibold form-control" name="btnadd">Add Category</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<?php 
include 'footer.php';
?>
