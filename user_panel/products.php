<?php
include 'header.php';

$allcategoriesdata = mysqli_query($conn,"SELECT * from categories");

if(isset($_POST['btnproduct'])){
    $productname = $_POST['product_name'];
    $productdescription = $_POST['product_description'];
    $user_id = $_SESSION['userid'];

    $selected_category_id = $_POST['product_category_id']; 
    $new_category_name = trim($_POST['new_category_name']); 

    $final_category_id = $selected_category_id; 

    if ($selected_category_id == 'new' && !empty($new_category_name)) {
        $safe_new_name = mysqli_real_escape_string($conn, $new_category_name);
        
        $check_existing = mysqli_query($conn, "SELECT categories_id FROM categories WHERE categories_name = '$safe_new_name'");

        if (mysqli_num_rows($check_existing) > 0) {
            $existing_cat = mysqli_fetch_assoc($check_existing);
            $final_category_id = $existing_cat['categories_id'];
        } else {
            $insert_new_cat = mysqli_query($conn, "INSERT INTO `categories` (`categories_name`) VALUES ('$safe_new_name')");
            
            if ($insert_new_cat) {
                $final_category_id = mysqli_insert_id($conn);
            } else {
                echo "<script>alert('⚠️ Error while adding new category!');</script>";
                exit; 
            }
        }
    } 
    
    $productimagename = $_FILES['product_image']['name'];
    $productimagetemp = $_FILES['product_image']['tmp_name'];
    $productdir = "../admin/products/";
    $productcheck = $productdir.$productimagename;
    
    $allproducts = mysqli_query($conn,"SELECT * from products where product_name = '$productname'");

    if(empty($final_category_id) || $final_category_id == 'new'){
         echo "<script>alert('❌ Please select a category or enter a new category name.');</script>";
         exit;
    }
    else if(file_exists($productcheck)){
         echo "<script>alert('❌ This Product image already exists! Please choose another product for review.');</script>";
    }
    else if(mysqli_num_rows($allproducts) > 0){
         echo "<script>alert('❌ This product name already exists! Please choose another name.');</script>";
    }
    else{
       $imagemoved = move_uploaded_file($productimagetemp,"../admin/products/".$productimagename);
       if($imagemoved){
        $insert = mysqli_query($conn, "
    INSERT INTO `products`(`product_name`, `product_description`, `product_category`, `product_image`,`user_id`) VALUES ('$productname','$productdescription','$final_category_id','$productimagename','$user_id')
");


        if($insert){
            echo "<script>alert('✅ Product added successfully!'); window.location='pending_products.php';</script>";
        }
        else{
            echo "<script>alert('⚠️ Error while inserting product data!');</script>";
        }
       }
       else{
        echo "<script>alert('⚠️ Error uploading image! Please try again.');</script>";
       }
    }
}
?>

<div class="container-fluid mt-4">

    <div class="d-sm-flex align-items-center justify-content-center mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-microscope text-success me-2"></i>
            <span class="text-success">Submit</span> Product for Testing
        </h1>
    </div>

    <p class="text-center text-secondary fs-6 mt-2 mb-4">
        Kindly fill out all fields below to initiate the product testing and review process.
    </p>

    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow-lg mb-5 border-left-success">
                <div class="card-header py-3 text-center bg-success bg-gradient rounded-top">
                    <h6 class="m-0 text-white fw-semibold"><i class="fas fa-file-invoice me-2"></i> Required Product Information</h6>
                </div>
                <div class="card-body p-4">

                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group mb-4">
                            <label for="productName" class="form-label fw-semibold text-dark">Product Name</label>
                            <input type="text" class="form-control form-control-lg border-secondary" id="productName" name="product_name" placeholder="E.g., Alpha V2 Prototype" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="productCategorySelect" class="form-label fw-semibold text-dark">Product Category</label>
                            <select class="form-select form-select-lg border-secondary" id="productCategorySelect" name="product_category_id" required>
                                <option value="" selected disabled>--- Select Category ---</option>
                               <?php foreach($allcategoriesdata as $category) { ?>
                                <option value="<?php echo htmlspecialchars($category['categories_id'])?>"><?php echo htmlspecialchars($category['categories_name'])?></option>
                               <?php }?>
                                <option value="new" class="fw-bold bg-light text-primary">-- Add New Category --</option>
                            </select>
                            <small class="text-muted mt-1 d-block">If no existing category matches, please choose 'Add New Category'.</small>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="newCategoryInput" class="form-label fw-semibold text-dark">New Category Name (If required)</label>
                            <input type="text" class="form-control form-control-lg border-secondary" id="newCategoryInput" name="new_category_name" placeholder="Enter new category name here">
                            <small class="text-danger mt-1 d-block">If creating a new category, ensure you select **'Add New Category'** from the dropdown above.</small>
                        </div>


                        <div class="form-group mb-4">
                            <label for="productImage" class="form-label fw-semibold text-dark">Product Image</label>
                            <input type="file" class="form-control form-control-lg border-secondary" id="productImage" name="product_image" required>
                            <small class="text-muted mt-1">Acceptable formats: JPG, PNG. Maximum size: 5MB.</small>
                        </div>

                        <div class="form-group mb-5">
                            <label for="productDescription" class="form-label fw-semibold text-dark">Description / Initial Complaint</label>
                            <textarea class="form-control form-control-lg border-secondary" id="productDescription" name="product_description" rows="4" placeholder="Describe the product and specify any known issues or focus points for testing." required></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 fw-semibold shadow-lg" name="btnproduct">
                                <i class="fas fa-upload me-2"></i> Submit Product
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