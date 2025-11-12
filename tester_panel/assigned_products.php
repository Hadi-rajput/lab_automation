<?php
include 'header.php';
$testerid = $_SESSION['userid'];
$allproducts = mysqli_query($conn, "SELECT * FROM products INNER JOIN categories ON products.product_category = categories.categories_id  WHERE products.assigned_tester_id = '$testerid' AND products.product_status = 'Approved' ORDER BY products.product_id DESC");

// Get the count for the header update
$product_count = mysqli_num_rows($allproducts);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-tasks text-primary me-2"></i>
            <span class="text-primary">Assigned</span> Products
        </h1>
        <p class="mb-0 text-secondary fw-medium d-none d-md-block">
            Ready to start testing? Total pending: 
            <span class="fw-bold text-danger">
                <?php echo $product_count; ?>
            </span>
        </p>
    </div>

    <h2 class="h5 text-dark mb-4 mt-4 fw-semibold"><i class="fas fa-list-alt me-2 text-info"></i> Products Awaiting Review</h2>
</div>

<div class="card shadow mb-4 border-left-primary">
    <div class="card-header py-3 bg-primary bg-gradient d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-microscope me-2"></i> Testing Queue</h6>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <?php if ($product_count > 0): ?>
                <table class="table table-hover table-striped text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light text-dark fw-bold border-bottom-2 border-primary">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allproducts as $products) { ?>
                            <tr>
                                <td class="text-primary fw-bold"><?php echo htmlspecialchars($products['product_id']) ?></td>
                                <td class="text-dark fw-semibold"><?php echo htmlspecialchars($products['product_name']) ?></td>
                                <td><?php echo htmlspecialchars($products['categories_name']) ?></td>
                                <td class="text-start small text-muted w-25"><?php echo htmlspecialchars(substr($products['product_description'], 0, 50)) . '...' ?></td>
                                <td>
                                    <img src="../admin/products/<?php echo htmlspecialchars($products['product_image']) ?>" alt="Product Image" width="70px" class="rounded shadow-sm">
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark px-3 py-2 fw-bold rounded-pill">
                                        <?php echo htmlspecialchars($products['product_status']) ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($products['created_at'])) ?></td>
                                <td>
                                    <a href="test_product.php?id=<?php echo htmlspecialchars($products['product_id']) ?>"
                                        class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill fw-semibold shadow-lg">
                                        <i class="fas fa-vial fs-5"></i>
                                        <span>Start Test</span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-success text-center py-4 my-3">
                    <h5 class="fw-bold mb-1"><i class="fas fa-thumbs-up me-2"></i> All clear!</h5>
                    You currently have no products assigned for testing.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php
include 'footer.php';
?>