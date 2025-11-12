<?php
session_start();
include '../config/db_connect.php';

$message = "";

if (isset($_POST['btnlogin'])) {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    $emailchecker = mysqli_query($conn, "SELECT * FROM users WHERE user_email = '$email'");

    if (mysqli_num_rows($emailchecker) > 0) {
        $user = mysqli_fetch_assoc($emailchecker);
        $userpassword = password_verify($password, $user['user_password']);

        if ($userpassword) {
            $_SESSION['userid'] = $user['user_id'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['useremail'] = $user['user_email'];
            $_SESSION['userrole'] = $user['role_id'];
            $_SESSION['userimage'] = $user['user_image'];

            if ($user['role_id'] == 3) {
                echo "<script>
                        alert('Welcome Admin!');
                        window.location.href = '../admin/index.php';
                      </script>";
            } elseif ($user['role_id'] == 2) {
                echo "<script>
                        alert('Welcome Tester!');
                        window.location.href = '../tester_panel/index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Welcome User!');
                        window.location.href = '../user_panel/index.php';
                      </script>";
            }
        } else {
            $message = '<div class="alert alert-danger text-center mt-3" role="alert">
                            Invalid password! Please check your credentials.
                        </div>';
        }
    } else {
        $message = '<div class="alert alert-warning text-center mt-3" role="alert">
                        Account not found! Please register first.
                    </div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Lab Automation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <div class="form-container shadow-lg">
            <h3 class="fw-bolder text-center py-2 text-primary">
             Login Account
            </h3>
            <hr class="border-primary border-2 opacity-75">

            <?php if (!empty($message)) echo $message; ?>

            <form action="" method="post" enctype="multipart/form-data">
                
                <div class="form-group mb-4">
                    <label for="useremail" class="form-label fw-semibold text-secondary small">
                        Enter Email
                    </label>
                    <input type="email" class="form-control form-control-lg" id="useremail" placeholder="Enter your email" name="useremail" required>
                </div>
                
                <div class="form-group mb-4">
                    <label for="userpassword" class="form-label fw-semibold text-secondary small">
                        Enter Password
                    </label>
                    <input type="password" class="form-control form-control-lg" id="userpassword" placeholder="Enter password" name="userpassword" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg form-control fw-bold shadow-sm login-btn" name="btnlogin">
                    LOGIN ACCOUNT
                </button>
                
                <p class="text-center mt-3 text-secondary fw-medium small">
                    Doesn't have an Account?
                    <a href="register.php" class="text-primary fw-bold text-decoration-none">Register Here</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>