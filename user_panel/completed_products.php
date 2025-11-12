<?php
include 'header.php';
$userid = $_SESSION['userid'];
$allproducts = mysqli_query($conn, "SELECT * FROM products INNER JOIN categories ON products.product_category = categories.categories_id WHERE products.user_id = '$userid' AND products.product_status = 'Complete' ORDER BY products.product_id DESC
");
?>

<style>
    .text-custom-light-yellow {
        color: #DAA520 !important;
    }
    .border-custom-light-yellow {
        border-color: #DAA520 !important;
    }
    .bg-custom-light-yellow {
        background-color: #FFF3CD !important;
        color: #333333 !important;
    }
    .btn-custom-yellow {
        background-color: #FFD700 !important;
        border-color: #FFD700 !important;
        color: #333333 !important;
    }
    .badge-custom-yellow {
        background-color: #DAA520 !important;
        color: white !important;
    }
</style>

<div class="container-fluid mt-4">

    <div class="d-sm-flex align-items-center justify-content-center mb-5 mt-2 pb-3 border-bottom border-custom-light-yellow border-opacity-50">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-check-circle text-custom-light-yellow me-2"></i>
            <span class="text-custom-light-yellow">Completed</span> Products
        </h1>
    </div>

    <p class="text-center text-secondary fs-6 mt-2 mb-4">
        These products have been successfully processed and finalized.
    </p>
    <hr class="w-25 mx-auto mb-5 border-custom-light-yellow border-2 opacity-75">


    <div class="card shadow-xl mb-4 border-start border-custom-light-yellow border-5">
        <div class="card-header py-4 d-flex justify-content-between align-items-center bg-custom-light-yellow rounded-top">
            <h5 class="m-0 text-dark fw-bold"><i class="fas fa-clipboard-check me-2"></i> Finalized Products List</h5>
            <a href="products.php" class="btn btn-outline-dark btn-sm fw-semibold">
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
                            <th>Final Review Summary</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($allproducts) > 0) {
                            foreach ($allproducts as $products) { 
                                $review_text = htmlspecialchars($products['review'] ?? 'N/A');
                                $summary_text = substr($review_text, 0, 30) . (strlen($review_text) > 30 ? '...' : '');
                        ?>
                            <tr>
                                <td class="fw-semibold text-custom-light-yellow"><?php echo $products['product_id'] ?></td>
                                <td class="text-start fw-medium text-dark"><?php echo $products['product_name'] ?></td>
                                <td><?php echo $products['categories_name'] ?></td>
                                <td class="text-muted small"><?php echo substr($products['product_description'], 0, 40) . (strlen($products['product_description']) > 40 ? '...' : '') ?></td>
                                <td><img src="../admin//products/<?php echo $products['product_image'] ?>" alt="Product Image" width="60px" class="img-thumbnail rounded shadow-sm"></td>
                                
                                <td><span class="badge badge-custom-yellow fw-bold p-2 text-uppercase"><i class="fas fa-check me-1"></i> <?php echo $products['product_status'] ?></span></td>
                                
                                <td>
                                    <span class="badge badge-custom-yellow fw-bold p-2 text-wrap" 
                                          title="<?php echo $review_text; ?>" 
                                          data-bs-toggle="tooltip" data-bs-placement="top" 
                                          style="max-width: 150px;">
                                        <?php echo $summary_text ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <a href="download.php?id=<?php echo $products['product_id']?>" class="btn btn-custom-yellow btn-sm d-inline-flex align-items-center gap-1 px-3 py-2 fw-bold text-uppercase shadow-lg">
                                        <i class="fas fa-download me-1 fs-6"></i>
                                        <span>Report (PDF)</span>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            } 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(mysqli_num_rows($allproducts) == 0): ?>
                <div class="alert alert-warning text-center mt-4 mb-0 bg-opacity-10 text-dark" role="alert">
                    <i class="fas fa-info-circle me-2"></i> You currently have no completed products to view.
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>