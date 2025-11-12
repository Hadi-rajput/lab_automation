<?php
include 'header.php';

if (!isset($_SESSION['userid'])) {
    header('Location: login.php'); 
    exit;
}

$userid = $_SESSION['userid'];

$allproducts = mysqli_query($conn, "SELECT * FROM products 
    INNER JOIN categories ON products.product_category = categories.categories_id 
    WHERE products.user_id = '$userid' 
    AND products.product_status = 'Approved' 
    ORDER BY products.product_id DESC");

if (!$allproducts) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<div class="container-fluid mt-4">

    <div class="d-sm-flex align-items-center justify-content-center mb-5 mt-2 pb-3 border-bottom border-success border-opacity-50">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-check-circle text-success me-2"></i>
            <span class="text-success">Approved</span> Products
        </h1>
    </div>

    <p class="text-center text-secondary fs-6 mt-2 mb-4">
        These products have been reviewed and approved by the admin.
    </p>
    <hr class="w-25 mx-auto mb-5 border-success border-2 opacity-75">


    <div class="card shadow-xl mb-4 border-start border-success border-5">
        <div class="card-header py-4 d-flex justify-content-between align-items-center bg-success bg-gradient rounded-top">
            <h5 class="m-0 text-white fw-bold"><i class="fas fa-list-check me-2"></i> Approved Products List</h5>
            <a href="products.php" class="btn btn-outline-light btn-sm fw-semibold">
                <i class="fas fa-plus-circle me-1"></i> Add New Product
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-secondary">
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
                            <tr>
                                <td class="fw-semibold text-success"><?php echo $products['product_id'] ?></td>
                                <td class="text-start fw-medium text-dark"><?php echo $products['product_name'] ?></td>
                                <td><?php echo $products['categories_name'] ?></td>
                                <td class="text-muted small"><?php echo substr($products['product_description'], 0, 40) . (strlen($products['product_description']) > 40 ? '...' : '') ?></td>
                                <td><img src="../admin/products/<?php echo $products['product_image'] ?>" alt="Product Image" width="60px" class="img-thumbnail rounded shadow-sm"></td>
                                <td><span class="badge bg-success fw-bold p-2 text-uppercase"><i class="fas fa-check me-1"></i> <?php echo $products['product_status'] ?></span></td>
                                <td class="small text-nowrap"><?php echo date('d M Y', strtotime($products['created_at'])) ?></td>
                                <td> 
                                    <a href="edit-product.php?id=<?php echo $products['product_id']; ?>" class="btn btn-outline-info btn-sm shadow-sm" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $products['product_id']; ?>" class="btn btn-outline-danger btn-sm shadow-sm" onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(mysqli_num_rows($allproducts) == 0): ?>
                <div class="alert alert-success text-center mt-4 mb-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i> You currently have no approved products.
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>