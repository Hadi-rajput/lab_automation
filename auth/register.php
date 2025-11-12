<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db_connect.php';

$message = "";

if (isset($_POST['btnregister'])) {
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $userpassword = $_POST['userpassword'];
    $userconfirmpassword = $_POST['userconfirmpassword'];
    $userimage = $_FILES['user_image']['name'];
    $userimagetmp = $_FILES['user_image']['tmp_name'];

    $emailcheck = mysqli_query($conn, "SELECT * from users where user_email = '$useremail'");

    if (mysqli_num_rows($emailcheck) > 0) {
        $message = '<div class="alert alert-warning text-center" role="alert">
                        ❌ Account already registered. Please login.
                    </div>';
    } elseif ($userpassword !== $userconfirmpassword) {
        $message = '<div class="alert alert-danger text-center" role="alert">
                        ❌ Passwords do not match!
                    </div>';
    } elseif (empty($userimage)) {
        $message = '<div class="alert alert-danger text-center" role="alert">
                        ❌ Please upload a profile picture!
                    </div>';
    } else {
        move_uploaded_file($userimagetmp, "../admin/userpfp/" . $userimage);
        $hashpassword = password_hash($userpassword, PASSWORD_DEFAULT);

        $insert = mysqli_query($conn, "INSERT INTO `users`
            (`user_name`, `user_email`, `user_password`, `user_image`, `role_id`)
            VALUES ('$username','$useremail','$hashpassword','$userimage',1)");

        if ($insert) {
            $message = '<div class="alert alert-success text-center" role="alert">
                            ✅ Account registered successfully! Redirecting...
                        </div>';
            echo "<script>
                    setTimeout(() => {
                        window.location.href='login.php';
                    }, 1500);
                  </script>";
        } else {
            $message = '<div class="alert alert-danger text-center" role="alert">
                            ❌ Database Error: ' . mysqli_error($conn) . '
                        </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Lab Automation</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
   
    <script src="https://kit.fontawesome.com/09308f2a9c.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="main-container">
        <div class="form-container shadow-lg">
            <h3 class="fw-bolder text-center py-2 text-primary">
                Register Account
            </h3>
            <hr class="border-primary border-2 opacity-75">

            <?php if (!empty($message)) echo $message; ?>

            <form action="" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                
                <div class="form-group mb-3">
                    <label for="username" class="form-label fw-semibold text-secondary small">
                        Enter Name
                    </label>
                    <input type="text" class="form-control form-control-lg" id="username" placeholder="e.g. Harry" name="username" required>
                    <div class="invalid-feedback">Please choose a username.</div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="useremail" class="form-label fw-semibold text-secondary small">
                        Enter Email
                    </label>
                    <input type="email" class="form-control form-control-lg" id="useremail" placeholder="e.g. Harry@gmail.com" name="useremail" required>
                    <div class="invalid-feedback">Please choose an email.</div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="user_image" class="form-label fw-semibold text-secondary small">
                        Upload Picture
                    </label>
                    <input type="file" class="form-control form-control-lg" id="user_image" name="user_image" accept="image/*" required>
                    <div class="invalid-feedback">Please choose a Profile Picture.</div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="userpassword" class="form-label fw-semibold text-secondary small">
                       Enter Password
                    </label>
                    <input type="password" class="form-control form-control-lg" id="userpassword" placeholder="Enter strong password" name="userpassword" required>
                    <div class="invalid-feedback">Please choose a Valid Password.</div>
                </div>
                
                <div class="form-group mb-4">
                    <label for="userconfirmpassword" class="form-label fw-semibold text-secondary small">
                        Re-enter Password
                    </label>
                    <input type="password" class="form-control form-control-lg" id="userconfirmpassword" placeholder="Confirm password" name="userconfirmpassword" required>
                    <div class="invalid-feedback">Please Re-enter the password.</div>
                </div>
                
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary btn-lg form-control fw-bold shadow-sm register-btn" name="btnregister">
                        REGISTER ACCOUNT
                    </button>
                    <p class="text-center mt-3 text-secondary fw-medium small">
                        Already have an Account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login Here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script>
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>