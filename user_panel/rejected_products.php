<?php
include 'header.php';
$userid = $_SESSION['userid'];
$allproducts = mysqli_query($conn, "SELECT * FROM products INNER JOIN categories ON products.product_category = categories.categories_id WHERE products.user_id = '$userid' AND products.product_status = 'Rejected' ORDER BY products.product_id DESC
");
?>

<div class="container-fluid mt-4">

    <div class="d-sm-flex align-items-center justify-content-center mb-5 mt-2 pb-3 border-bottom border-danger border-opacity-50">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">    
            <i class="fas fa-times-circle text-danger me-2"></i>
            <span class="text-danger">Rejected</span> Products
        </h1>
    </div>

    <p class="text-center text-secondary fs-6 mt-2 mb-4">
        These are the products that were reviewed but unfortunately not approved.
    </p>
    <hr class="w-25 mx-auto mb-5 border-danger border-2 opacity-75">


    <div class="card shadow-xl mb-4 border-start border-danger border-5">
        <div class="card-header py-4 d-flex justify-content-between align-items-center bg-danger bg-gradient rounded-top">
            <h5 class="m-0 text-white fw-bold"><i class="fas fa-ban me-2"></i> Rejected Products List</h5>
            <a href="products.php" class="btn btn-outline-light btn-sm fw-semibold">
                <i class="fas fa-plus-circle me-1"></i> Submit New Product
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Complaint/Issue</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Rejection Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($allproducts) > 0) {
                            foreach ($allproducts as $products) { 
                        ?>
                            <tr>
                                <td class="fw-semibold text-danger"><?php echo $products['product_id'] ?></td>
                                <td class="text-start fw-medium text-dark"><?php echo $products['product_name'] ?></td>
                                <td><?php echo $products['categories_name'] ?></td>
                                <td class="text-muted small"><?php echo substr($products['product_description'], 0, 40) . (strlen($products['product_description']) > 40 ? '...' : '') ?></td>
                                <td><img src="../admin//products/<?php echo $products['product_image'] ?>" alt="Product Image" width="60px" class="img-thumbnail rounded shadow-sm"></td>
                                <td><span class="badge bg-danger text-white fw-bold p-2 text-uppercase"><i class="fas fa-times me-1"></i> <?php echo $products['product_status'] ?></span></td>
                                <td class="small text-start text-dark fw-medium"><?php echo htmlspecialchars($products['review'] ?? 'N/A') ?></td>
                            </tr>
                        <?php 
                            } 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(mysqli_num_rows($allproducts) == 0): ?>
                <div class="alert alert-danger text-center mt-4 mb-0 bg-opacity-10" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> You currently have no rejected products.
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>