<?php
include 'header.php';

$id = $_GET['id'];

// PHP logic remains untouched as requested
$productQuery = mysqli_query($conn, "SELECT products.*, users.user_name FROM products INNER JOIN users ON products.user_id = users.user_id WHERE products.product_id = '$id'");

$products = mysqli_fetch_assoc($productQuery);

$categories = mysqli_query($conn, "SELECT * FROM categories");


if (isset($_POST['btnproduct'])) {
    $complain = $_POST['product_description'];
    $category = $_POST['update_category'];
    $review = $_POST['review'];

    if (empty($_POST['update_category'])) {
        $query = mysqli_query($conn, "UPDATE `products` SET `product_description`='$complain',`product_status`='Complete',`review`='$review' WHERE product_id = $id");

        if($query){
            echo "
            <script>
                alert('Your action is completed successfully!');
                    window.location.href = 'completed_products.php'; 
                        </script>
";
        }
    }
    else{
        $q = mysqli_query($conn,"UPDATE `products` SET `product_description`='$complain',`product_category`='$category',`product_status`='Complete',`review`='$review' WHERE product_id = $id");

        if($q){
             echo "
            <script>
                alert('Your action is completed successfully!');
                    window.location.href = 'completed_products.php'; 
                        </script>
";
        }
    }
}


?>

<div class="container-fluid mt-4">

    <div class="d-sm-flex align-items-center justify-content-center mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-vial text-primary me-2"></i>
            <span class="text-primary">Test & Finalize</span> Product Review
        </h1>
    </div>

    <p class="text-center text-secondary fs-6 mt-2 mb-4">
        Review the product details below, perform the necessary testing, and submit the final review status.
    </p>

    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow-lg mb-5 border-left-primary">
                <div class="card-header py-3 text-center bg-primary bg-gradient rounded-top">
                    <h6 class="m-0 text-white fw-semibold"><i class="fas fa-flask me-2"></i> Product Testing and Status Update</h6>
                </div>
                
                <div class="card-body p-4">

                    <div class="mb-4 p-3 border rounded bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="../admin/products/<?php echo htmlspecialchars($products['product_image']) ?>" alt="Product Image" width="80px" class="rounded shadow-sm border p-1">
                            </div>
                            <div class="col">
                                <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($products['product_name']) ?></h5>
                                <p class="mb-0 small text-muted">Submitted by: <?php echo htmlspecialchars($products['user_name']) ?></p>
                            </div>
                        </div>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group mb-3">
                            <label for="productName" class="form-label fw-semibold text-dark">Product Name</label>
                            <input type="text" class="form-control form-control-lg bg-light" id="productName" name="product_name" value="<?php echo htmlspecialchars($products['product_name']) ?>" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="updateCategory" class="form-label fw-semibold text-dark">Category (Optional Update)</label>
                            <select name="update_category" id="updateCategory" class="form-select form-select-lg">
                                <option value="" selected>-- Keep Current Category --</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option
                                        value="<?php echo htmlspecialchars($category['categories_id']); ?>"
                                        <?php if ($category['categories_id'] == $products['product_category']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($category['categories_name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="text-muted">Current: <?php 
                                $current_cat_id = $products['product_category'];
                                $current_cat_name = '';
                                foreach ($categories as $category) {
                                    if ($category['categories_id'] == $current_cat_id) {
                                        $current_cat_name = $category['categories_name'];
                                        break;
                                    }
                                }
                                echo htmlspecialchars($current_cat_name);
                            ?></small>
                        </div>
                            
                        <div class="form-group mb-3">
                            <label for="reviewStatus" class="form-label fw-semibold text-dark">Final Test Review Status</label>
                            <select class="form-control form-select-lg" id="reviewStatus" name="review" required>
                                <option value="" disabled selected>Select Review Result...</option>
                                <option value="pass" class="text-success fw-bold" <?php if ($products['review'] == 'pass') echo 'selected'; ?>>✅ Pass (Testing Successful)</option>
                                <option value="fail" class="text-danger fw-bold" <?php if ($products['review'] == 'fail') echo 'selected'; ?>>❌ Fail (Needs Rework/Re-submission)</option>
                            </select>
                        </div>


                        <div class="form-group mb-4">
                            <label for="productDescription" class="form-label fw-semibold text-dark">Test Report / Feedback</label>
                            <textarea class="form-control form-control-lg" id="productDescription" name="product_description" rows="4" placeholder="Enter detailed test results or feedback here..." required><?php echo htmlspecialchars($products['product_description']) ?></textarea>
                            <small class="text-muted">This field now serves as the **final test report**.</small>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 fw-semibold shadow-sm" name="btnproduct" onclick="return confirm('WARNING: Are you sure you want to finalize this product status? This action cannot be easily undone.')">
                                <i class="fas fa-check-double me-2"></i> Finalize Review
                            </button>
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