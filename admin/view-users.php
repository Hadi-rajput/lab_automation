<?php
include 'header.php';

$alluser_result = mysqli_query($conn, "SELECT users.user_id,users.user_name,users.user_email,users.user_image,roles.role_name FROM users INNER JOIN roles ON users.role_id = roles.role_id");
$alluser = mysqli_fetch_all($alluser_result, MYSQLI_ASSOC);
?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-users-cog text-primary me-2"></i>
            <span class="text-primary">USER</span> Management
        </h1>
        <p class="mb-0 text-muted small">
            <i class="fas fa-database me-1"></i> Total Users: <span class="fw-bold text-dark"><?php echo count($alluser); ?></span>
        </p>
    </div>

    <div class="card bg-info text-white shadow mb-4">
        <div class="card-body py-2">
            <i class="fas fa-info-circle me-2"></i>
            <span class="fw-bold">User Access Control:</span> Manage all system users, including their roles and credentials, from this table.
        </div>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-table me-2"></i> Registered System Users
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No.</th>
                            <th><i class="fas fa-user"></i> Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th>Image</th>
                            <th><i class="fas fa-briefcase"></i> Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alluser as $users) {
                            $role_class = match ($users['role_name']) {
                                'Admin' => 'bg-danger',
                                'Uploader' => 'bg-success',
                                'Tester' => 'bg-warning text-dark',
                                default => 'bg-secondary',
                            };
                        ?>
                            <tr>
                                <td class="fw-bold text-primary"><?php echo $users['user_id']; ?></td>
                                <td class="text-start fw-bold text-gray-800"><?php echo $users['user_name']; ?></td>
                                <td class="text-start small text-muted"><?php echo $users['user_email']; ?></td>
                                <td>
                                    <img src="userpfp/<?php echo $users['user_image']; ?>" 
                                         alt="Profile Picture" 
                                         style="width: 40px; height: 40px; object-fit: cover;"
                                         class="rounded-circle img-thumbnail border border-primary p-0">
                                </td>
                                <td>
                                    <span class="badge rounded-pill <?php echo $role_class; ?>">
                                        <?php echo $users['role_name']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-grid gap-1 d-md-flex justify-content-center">
                                        <a href="edit-user.php?id=<?php echo $users['user_id']; ?>"
                                            class="btn btn-warning btn-sm"
                                            title="Edit User">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="delete_user.php?id=<?php echo $users['user_id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete <?php echo $users['user_name']; ?>?');"
                                            title="Delete User">
                                            <i class="fa-solid fa-trash"></i> Delete
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