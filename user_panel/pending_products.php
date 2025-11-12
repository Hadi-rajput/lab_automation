<?php
include 'header.php';
$userid = $_SESSION['userid'];
$allproducts = mysqli_query($conn, "SELECT * FROM products INNER JOIN categories ON products.product_category = categories.categories_id WHERE products.user_id = '$userid' AND products.product_status = 'Pending'ORDER BY products.product_id DESC");
?>

<div class="container-fluid mt-4">

<div class="d-sm-flex align-items-center justify-content-center mb-5 mt-2 border-bottom pb-3">
    <h1 class="h3 mb-0 text-gray-800 fw-bolder">
        <i class="fas fa-hourglass-half text-primary me-2"></i>
        <span class="text-primary">Pending</span> Products
    </h1>
</div>

<p class="text-center text-secondary fs-6 mt-2 mb-4">
    These products are currently under review. Please await approval.
</p>
<hr class="w-50 mx-auto mb-5 border-primary border-1">


    <div class="card shadow-lg mb-4 border-left-primary">
        <div class="card-header py-4 d-flex justify-content-between align-items-center bg-primary bg-gradient rounded-top">
            <h5 class="m-0 text-white fw-bold">⏳ Products Awaiting Review</h5>
            <a href="products.php" class="btn btn-light btn-sm fw-semibold shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Add New Product
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover table-sm text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Complaint/Issue</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allproducts as $products) { ?>
                            <tr class="table-primary bg-opacity-25">
                                <td class="fw-semibold"><?php echo $products['product_id'] ?></td>
                                <td class="text-start fw-medium"><?php echo $products['product_name'] ?></td>
                                <td><?php echo $products['categories_name'] ?></td>
                                <td class="text-muted small"><?php echo substr($products['product_description'], 0, 40) . (strlen($products['product_description']) > 40 ? '...' : '') ?></td>
                                <td><img src="../admin//products/<?php echo $products['product_image'] ?>" alt="Product Image" width="60px" class="img-thumbnail rounded shadow-sm"></td>
                                <td><span class="badge bg-primary text-white fw-bold p-2"><i class="fas fa-clock me-1"></i> <?php echo $products['product_status'] ?></span></td>
                                <td class="small text-nowrap"><?php echo date('d M Y', strtotime($products['created_at'])) ?></td>
                                <td> 
                                    <a href="edit-product.php?id=<?php echo $products['product_id']; ?>" class="btn btn-info btn-sm text-white shadow-sm" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $products['product_id']; ?>" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(mysqli_num_rows($allproducts) == 0): ?>
                <div class="alert alert-info text-center mt-4 mb-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i> You currently have no pending products awaiting review.
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>