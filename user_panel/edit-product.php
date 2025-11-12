<?php
include 'header.php';

$id = $_GET['id'];



$productQuery = mysqli_query($conn, "SELECT products.*, users.user_name FROM products INNER JOIN users ON products.user_id = users.user_id WHERE products.product_id = '$id'");

$products = mysqli_fetch_assoc($productQuery);

$categories = mysqli_query($conn,"SELECT * FROM categories");

$productoldimage = $products['product_image'];
$oldcategory = $products['product_category'];

if(isset($_POST['btnproduct'])){
    $updatename = $_POST['product_name'];
    $updatedescription = $_POST['product_description'];
    $updatecategory = $_POST['update_category'];

    if(empty($updatecategory)){
        $updatecategory = $oldcategory;
    }

    $newproductimage = $productoldimage;

    if(!empty($_FILES['product_image']['name'])){
        $newproductimage = $_FILES['product_image']['name'];
        $newproducttemp = $_FILES['product_image']['tmp_name'];
        move_uploaded_file($newproducttemp,'../admin/products/'.$newproductimage);

        $productoldpath = '../admin/products/'.$productoldimage;
        if(file_exists($productoldpath)){
            unlink($productoldpath);
        }
  }
  if(empty($updatecategory)){
    $query= mysqli_query($conn,"UPDATE `products` SET `product_name`='$updatename',`product_description`='$updatedescription',`product_image`='$newproductimage' WHERE product_id = $id");

    if($query){
         echo "
            <script>
                alert('Product updated successfully (without category)!');
                window.location.href = 'pending_products.php';
            </script>
            ";
    }
  }
  else if(empty($updatedescription)){
    $query = mysqli_query($conn,"UPDATE `products` SET `product_name`='$updatename',`product_description`='[value-3]',`product_category`='$updatecategory',`product_image`='$newproductimage' WHERE product_id = $id");

     if($query){
         echo "
            <script>
                alert('Product updated successfully (without Description)!');
                window.location.href = 'pending_products.php';
            </script>
            ";
    }

  }
  else if(empty($updatename)){
    $query = mysqli_query($conn,"UPDATE `products` SET `product_description`='$updatedescription',`product_category`='$updatecategory',`product_image`='$newproductimage' WHERE product_id = $id");

     if($query){
         echo "
            <script>
                alert('Product updated successfully (without name)!');
                window.location.href = 'pending_products.php';
            </script>
            ";
    }
  }
  else{
    $query = mysqli_query($conn,"UPDATE `products` SET `product_name`='$updatename',`product_description`='$updatedescription',`product_category`='$updatecategory',`product_image`='$newproductimage' WHERE product_id = $id");

    if($query){
         echo "
            <script>
                alert('Product updated successfully!');
                window.location.href = 'pending_products.php';
            </script>
            ";
    }
  }
}




?>

<div class="container-fluid mt-4">

<div class="text-center mb-5">
    <h1 class="fw-bold text-primary display-5">✏️ Update Product Details</h1>
    <p class="text-muted fs-5 mt-2">
        Make changes to your submitted product information and update it for further testing or review.
    </p>
    <hr class="w-25 mx-auto border-primary border-2">
</div>

<h2 class="h4 fw-bold text-dark mb-4 text-center">Edit Product Information</h2>


    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow mb-5 border-0">
                <div class="card-header py-3 text-center bg-primary">
                    <h6 class="m-0 text-white fw-semibold">Add Product Details Below</h6>
                </div>
                <div class="card-body bg-light">

                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group mb-3">
                            <label for="productName" class="fw-semibold text-dark">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="product_name" value="<?php echo $products['product_name']?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="" class="fw-semibold text-dark">Categories</label>
                            <select name="update_category" class="form-select">
                                <?php foreach ($categories as $category) { ?>
                                    <option
                                        value="<?php echo $category['categories_id']; ?>"
                                        <?php if ($category['categories_id'] == $products['product_category']) echo 'selected disabled'; ?>>
                                        <?php echo $category['categories_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="productImage" class="fw-semibold text-dark">Product Image</label>
                            <input type="file" class="form-control" id="productImage" name="product_image">
                        </div>

                        <div class="form-group mb-4">
                            <label for="productDescription" class="fw-semibold text-dark">Description</label>
                            <textarea class="form-control" id="productDescription" name="product_description" rows="3"><?php echo $products['product_description']?></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5 fw-semibold" name="btnproduct">
                                Add Product
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
