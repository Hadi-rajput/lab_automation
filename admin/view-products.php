<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
include 'header.php';

$allproducts_result = mysqli_query($conn, " SELECT products.*,
           users.user_name AS uploader,
           categories.categories_name,
           tester.user_name AS tester_name
    FROM products
    INNER JOIN users ON products.user_id = users.user_id
    INNER JOIN categories ON products.product_category = categories.categories_id
    LEFT JOIN users AS tester ON products.assigned_tester_id = tester.user_id
    ORDER BY products.product_id DESC");
$allproducts = mysqli_fetch_all($allproducts_result, MYSQLI_ASSOC);

// Fetch testers only once
$testers_result = mysqli_query($conn, "SELECT user_id, user_name from users where role_id = 2");
$testers = mysqli_fetch_all($testers_result, MYSQLI_ASSOC);
?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-boxes text-primary me-2"></i>
            <span class="text-primary">ADMIN</span> Product Review
        </h1>
        <p class="mb-0 text-muted small">
            <i class="fas fa-calendar-alt me-1"></i> Today: <?php echo date('M d, Y'); ?>
        </p>
    </div>

    <div class="card bg-info text-white shadow mb-4">
        <div class="card-body py-2">
            <i class="fas fa-info-circle me-2"></i>
            <span class="fw-bold">Management Panel:</span> This list contains all products. Use the Tester column to assign reviewers and the Action buttons for approval/rejection.
        </div>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list-alt me-2"></i> All Products
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th><i class="fas fa-bell"></i> Status</th>
                            <th>Date Added</th>
                            <th><i class="fas fa-user-check"></i> Tester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allproducts as $products) {
                            // Determine badge class for Status consistency
                            $status_class = match ($products['product_status']) {
                                'pending' => 'bg-warning text-dark', // Use warning for pending
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                            $tester_assigned = !empty($products['assigned_tester_id']);
                        ?>
                            <tr>
                                <td class="fw-bold">
                                    #<?php echo $products['product_id'] ?>
                                </td>
                                <td class="text-start fw-bold text-gray-800">
                                    <?php echo $products['product_name'] ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo $products['categories_name'] ?></span>
                                </td>
                                <td class="text-start small text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo $products['product_description'] ?>
                                </td>
                                <td>
                                    <img src="./products/<?php echo $products['product_image'] ?>" alt="Product Image" width="50px" class="img-thumbnail rounded-3">
                                </td>
                                <td>
                                    <span class="badge rounded-pill <?php echo $status_class; ?>">
                                        <?php echo ucfirst($products['product_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo date('Y-m-d', strtotime($products['created_at'])) ?>
                                </td>
                                <td>
                                    <form action="assign-tester.php" method="get">
                                        <input type="hidden" name="product_id" value="<?php echo $products['product_id'] ?>">
                                        <select name="tester_id"
                                            class="form-select form-select-sm fw-medium <?php echo $tester_assigned ? 'border-success text-success' : 'border-info text-dark'; ?>"
                                            onchange="this.form.submit()" title="Assign a tester">

                                            <option value="" disabled <?php echo empty($products['assigned_tester_id']) ? 'selected' : ''; ?> class="bg-light">
                                                <?php echo $tester_assigned ? 'Assigned: ' . $products['tester_name'] : 'Select Tester...'; ?>
                                            </option>
                                            
                                            <?php if ($tester_assigned) { ?>
                                                <option value="0" class="text-danger">
                                                    -- Unassign Tester --
                                                </option>
                                            <?php } ?>

                                            <?php foreach ($testers as $tester) { ?>
                                                <option value="<?php echo $tester['user_id']; ?>"
                                                    <?php echo ($products['assigned_tester_id'] == $tester['user_id']) ? 'selected' : ''; ?>>
                                                    <?php echo $tester['user_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </form>
                                    </td>
                                <td>
                                    <div class="d-grid gap-1">
                                        <a href="product-approved.php?id=' . $products['product_id'] . '&tester_id=' . $products['assigned_tester_id'] . '"
                                            class="btn btn-success btn-sm text-nowrap"
                                            title="Approve this product">
                                            <i class="fas fa-check"></i> Approve
                                        </a>
                                        <a href="product-reject.php?id=<?php echo $products['product_id'] ?>"
                                            class="btn btn-danger btn-sm text-nowrap"
                                            title="Reject this product">
                                            <i class="fas fa-times"></i> Reject
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>