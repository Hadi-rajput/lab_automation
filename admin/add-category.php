<?php
include 'header.php';

if (isset($_POST['btnadd'])) {

    $categoryname = $_POST['categoryname'];

    $insert = mysqli_query($conn,"INSERT INTO `categories`(`categories_name`) VALUES ('$categoryname')");

    if($insert){
         echo "<script>alert('✅ category added successfully!'); window.location.href='view-categories.php';</script>";
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
                            <input type="text" class="form-control" name="categoryname" placeholder="e.g. Fuse" required>
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
