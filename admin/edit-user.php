<?php
include 'header.php';


$idtobeupdated = $_GET['id'];

$userall = mysqli_query($conn, "SELECT users.*, roles.role_name FROM users INNER JOIN roles ON users.role_id = roles.role_id WHERE users.user_id = $idtobeupdated");
$user = mysqli_fetch_assoc($userall);

$allroles_result = mysqli_query($conn, "SELECT * FROM roles");
$allroles = mysqli_fetch_all($allroles_result, MYSQLI_ASSOC);

$oldimagename = $user["user_image"];
$oldpassword = $user["user_password"];
$oldrole = $user["role_id"];

if (isset($_POST['btnupt'])) {
    $updatename = $_POST['username'];
    $updateemail = $_POST['useremail'];
    $updatepassword = $_POST['password'];
    $updaterole = $_POST['role_id'];

    if (empty($updaterole)) {
        $updaterole = $oldrole;
    }

    $newuserimage = $oldimagename;

 
    if (!empty($_FILES['user_image']['name'])) {
        $newuserimage = $_FILES['user_image']['name'];
        $newtmpname = $_FILES['user_image']['tmp_name'];
        
        $newuserimage = preg_replace("/[^a-zA-Z0-9\.]/", "_", $newuserimage);

        move_uploaded_file($newtmpname, "userpfp/" . $newuserimage);

       
        $oldimagepath = "userpfp/" . $oldimagename;
        
        if (file_exists($oldimagepath) && $oldimagename != 'default.png' && $oldimagename != 'placeholder.jpg') { 
            unlink($oldimagepath);
        }
    }

   
    if (empty($updatepassword)) {
       
        $query = "UPDATE `users` SET 
                    `user_name`='$updatename',
                    `user_email`='$updateemail',
                    `user_image`='$newuserimage',
                    `role_id`='$updaterole'
                  WHERE user_id = $idtobeupdated";
        $run = mysqli_query($conn, $query);

        if ($run) {
            echo "
            <script>
                alert('User updated successfully (without password)!');
                window.location.href = 'view-users.php';
            </script>
            ";
        }
    } else {
       
        $newpassword = password_hash($updatepassword, PASSWORD_DEFAULT);
        $query = "UPDATE `users` SET 
                    `user_name`='$updatename',
                    `user_email`='$updateemail',
                    `user_password`='$newpassword',
                    `user_image`='$newuserimage',
                    `role_id`='$updaterole'
                  WHERE user_id = $idtobeupdated";
        $run = mysqli_query($conn, $query);

        if ($run) {
            echo "
            <script>
                alert('User updated successfully (with new password)!');
                window.location.href = 'view-users.php';
            </script>
            ";
        }
    }
}
?>


<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bolder">
            <i class="fas fa-user-edit text-primary me-2"></i>
            <span class="text-primary">EDIT</span> User
        </h1>
        <a href="view-users.php" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
            <i class="fas fa-users fa-sm text-white-50"></i> View All Users
        </a>
    </div>

    <div class="card bg-warning text-dark shadow mb-4">
        <div class="card-body py-2">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <span class="fw-bold">Current User:</span> You are editing <?php echo htmlspecialchars($user['user_name']); ?> (ID: #<?php echo $idtobeupdated; ?>). Password field can be left blank to keep the current password.
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card shadow mb-5 border-left-primary">
                <div class="card-header py-3 text-center bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user-circle me-2"></i> Update User Credentials & Role
                    </h6>
                </div>
                <div class="card-body p-4">

                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group mb-4">
                            <label for="username" class="fw-bold text-gray-800 mb-2">
                                <i class="fas fa-user me-1 text-primary"></i> User Name
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg border-primary" 
                                   name="username" 
                                   value="<?php echo htmlspecialchars($user['user_name']); ?>" 
                                   required 
                                   placeholder="Enter full name">
                        </div>

                        <div class="form-group mb-4">
                            <label for="useremail" class="fw-bold text-gray-800 mb-2">
                                <i class="fas fa-envelope me-1 text-primary"></i> User Email
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg border-primary" 
                                   name="useremail" 
                                   value="<?php echo htmlspecialchars($user['user_email']); ?>" 
                                   required 
                                   placeholder="Enter email address">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="role_id" class="fw-bold text-gray-800 mb-2">
                                <i class="fas fa-users-cog me-1 text-primary"></i> Assign Role
                                <span class="badge bg-secondary ms-2"><?php echo htmlspecialchars($user['role_name']); ?> (Current)</span>
                            </label>
                            <select name="role_id" class="form-select form-select-lg border-primary">
                                <option value="" disabled selected>
                                    -- Select New Role (Currently: <?php echo htmlspecialchars($user['role_name']); ?>) --
                                </option>
                                
                                <?php foreach ($allroles as $role) { ?>
                                    <option
                                        value="<?php echo $role['role_id']; ?>"
                                        <?php if ($role['role_id'] == $user['role_id']) echo 'disabled'; ?>>
                                        <?php echo $role['role_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="fw-bold text-gray-800 mb-2">
                                <i class="fas fa-lock me-1 text-primary"></i> New Password
                                <span class="text-muted small ms-2">(Leave blank to keep current password)</span>
                            </label>
                            <input type="password" 
                                   class="form-control form-control-lg border-info" 
                                   name="password" 
                                   placeholder="Enter strong password (optional)">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="user_image" class="fw-bold text-gray-800 mb-2">
                                <i class="fas fa-image me-1 text-primary"></i> Profile Picture
                                <span class="text-muted small ms-2">(Current Image: <?php echo htmlspecialchars($user['user_image']); ?>)</span>
                            </label>
                            <div class="d-flex align-items-center">
                                <img src="userpfp/<?php echo htmlspecialchars($user['user_image']); ?>" 
                                     alt="Current PFP" 
                                     style="width: 50px; height: 50px; object-fit: cover;"
                                     class="rounded-circle img-thumbnail me-3 border-primary p-0">
                                <input type="file" class="form-control border-primary" name="user_image">
                            </div>
                        </div>


                        <div class="text-center mt-5">
                            <button type="submit" 
                                    class="btn btn-primary btn-lg w-75 fw-bold shadow-lg text-uppercase" 
                                    name="btnupt">
                                <i class="fas fa-sync-alt me-2"></i> Update User
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