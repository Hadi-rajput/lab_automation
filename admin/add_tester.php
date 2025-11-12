<?php
include "header.php";
$message = "";

if(isset($_POST["submit"])){
    $tester_name = $_POST["tester_name"];
    $tester_email = $_POST["tester_email"];
    $tester_password = $_POST["tester_password"];
    $tester_password_confirmation = $_POST["tester_confirm_password"];
    $tester_image_name = $_FILES["tester_picture"]["name"];
    $tester_image_path = $_FILES["tester_picture"]["tmp_name"];

    $all_tester = mysqli_query($conn,"SELECT * FROM users Where user_email = '$tester_email'");

    if(mysqli_num_rows($all_tester) > 0){
         $message = '<div class="alert alert-warning text-center" role="alert">
                        ❌ This tester is already Register.
                    </div>';
    } elseif($tester_password != $tester_password_confirmation){
        $message = '<div class="alert alert-danger text-center" role="alert">
                        ❌ Passwords do not match!
                    </div>';
    } elseif(empty($tester_image_name)){
        $message = '<div class="alert alert-danger text-center" role="alert">
                        ❌ Please upload a profile picture!
                    </div>';
    } else{
        move_uploaded_file($tester_image_path,"userpfp/".$tester_image_name);
        $tester_hash_password = password_hash($tester_password,PASSWORD_DEFAULT);

        $insert = mysqli_query($conn,"INSERT INTO `users`(`user_name`, `user_email`, `user_password`, `user_image`, `role_id`) VALUES ('$tester_name','$tester_email','$$tester_hash_password','$tester_image_name',2)");

        if($insert){
            $message = '<div class="alert alert-success text-center" role="alert">
                            ✅ Account registered successfully! Redirecting...
                        </div>';

                          echo "<script>
                    setTimeout(() => {
                        window.location.href='view-users.php';
                    }, 1500);
                  </script>";
        } else{
            $message = '<div class="alert alert-danger text-center" role="alert">
                            ❌ Database Error: ' . mysqli_error($conn) . '
                        </div>';
        }
    }

}
?>
  <style>
    body {
      background: #f8f9fc;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border-left: 5px solid #4e73df;
      border-radius: 15px;
    }
    .card-header {
      background: linear-gradient(135deg, #4e73df, #224abe);
      color: #fff;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }
    .btn-primary {
      background: #4e73df;
      border: none;
    }
    .btn-primary:hover {
      background: #224abe;
    }
  </style>

    <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">

        <div class="card shadow-lg">
          <div class="card-header text-center py-3">
            <h4 class="mb-0 fw-semibold">
              <i class="fas fa-user-plus me-2"></i> Add New Tester
            </h4>
          </div>

          <div class="card-body p-4">

          <?php if (!empty($message)) echo $message; ?>

            <form action="" method="post" enctype="multipart/form-data">

              <!-- Name -->
              <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Tester Name</label>
                <input type="text" class="form-control form-control-lg bg-light" placeholder="Enter tester name" required name="tester_name">
              </div>

              <!-- Email -->
              <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Email</label>
                <input type="email" class="form-control form-control-lg bg-light" placeholder="Enter email" required name="tester_email">
              </div>

              <!-- Password -->
              <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Password</label>
                <input type="password" class="form-control form-control-lg bg-light" placeholder="Enter password" required name="tester_password">
              </div>

               <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Confirm Password</label>
                <input type="password" class="form-control form-control-lg bg-light" placeholder="Re-enter password" required name="tester_confirm_password">
              </div>

              <!-- Picture -->
              <div class="form-group mb-4">
                <label class="form-label fw-semibold text-dark">Profile Picture</label>
                <input type="file" class="form-control form-control-lg bg-light" accept="image/*" name="tester_picture">
                <small class="text-muted">Allowed: JPG, PNG, GIF (max 2MB)</small>
              </div>

              <!-- Buttons -->
              <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-4 fw-semibold shadow-sm" name="submit">
                  <i class="fas fa-user-plus me-2"></i> Add Tester
                </button>
               
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

<?php
include "footer.php";
?>