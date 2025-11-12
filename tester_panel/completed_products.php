<?php
include 'header.php';
$userid = $_SESSION['userid'];
$allproducts = mysqli_query($conn, "SELECT * FROM products INNER JOIN categories ON products.product_category = categories.categories_id WHERE products.assigned_tester_id = '$userid' AND products.product_status = 'Complete' 
AND products.review = 'pass' ORDER BY products.product_id DESC");

// Get the count for the header update
$product_count = mysqli_num_rows($allproducts);
?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-check-circle text-success me-2"></i>
            <span class="text-success">Completed</span> Products
        </h1>
        <p class="mb-0 text-secondary fw-medium d-none d-md-block">
            View your successfully finalized products. Total completed: 
            <span class="fw-bold text-success">
                <?php echo $product_count; ?>
            </span>
        </p>
    </div>

    <h2 class="h5 text-dark mb-4 mt-4 fw-semibold"><i class="fas fa-history me-2 text-primary"></i> Review History (Passed)</h2>

    <div class="card shadow mb-4 border-left-success">
        <div class="card-header py-3 bg-success bg-gradient d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-clipboard-check me-2"></i> Successfully Finalized Products</h6>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <?php if ($product_count > 0): ?>
                    <table class="table table-hover table-striped text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light text-dark fw-bold border-bottom-2 border-success">
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Review Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allproducts as $products) {  ?>
                                <tr>
                                    <td class="text-primary fw-bold"><?php echo htmlspecialchars($products['product_id'])?></td>
                                    <td class="text-dark fw-semibold"><?php echo htmlspecialchars($products['product_name'])?></td>
                                    <td><?php echo htmlspecialchars($products['categories_name'])?></td>
                                    <td class="text-start small text-muted w-25"><?php echo htmlspecialchars(substr($products['product_description'], 0, 50)) . '...' ?></td>
                                    <td>
                                        <img src="../admin/products/<?php echo htmlspecialchars($products['product_image'])?>" alt="Product Image" width="80px" class="rounded shadow-sm">
                                    </td>
                                    <td>
                                        <span class="badge bg-success text-white px-3 py-2 fw-bold rounded-pill">
                                            <?php echo htmlspecialchars($products['product_status'])?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary text-white px-3 py-2 fw-bold rounded-pill text-uppercase">
                                            <i class="fas fa-thumbs-up me-1"></i> <?php echo htmlspecialchars($products['review'])?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning text-center py-4 my-3">
                        <h5 class="fw-bold mb-1"><i class="fas fa-info-circle me-2"></i> No Completed Products Found</h5>
                        You haven't successfully completed any product reviews that passed the test yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>