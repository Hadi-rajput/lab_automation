<?php
session_start();
include '../config/db_connect.php';
if (!isset($_SESSION['username']) || $_SESSION['userrole'] == 3 || $_SESSION['userrole'] == 2) {
    echo "<script>window.location.href='../auth/login.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Control Panel</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/09308f2a9c.js" crossorigin="anonymous"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fc;
    }

    .sidebar {
      background: linear-gradient(180deg, #212529 0%, #1c1f23 100%);
      min-height: 100vh;
      transition: all 0.3s ease;
    }

    .sidebar .nav-link {
      color: #adb5bd !important;
      font-weight: 500;
      border-radius: 10px;
      transition: all 0.3s ease;
      /* Base padding and margin adjusted for stability */
      padding: 10px 10px 10px 18px; 
      margin: 2px 5px; 
      overflow: hidden; 
      white-space: nowrap;
    }

    .sidebar .nav-link:hover {
      background: linear-gradient(90deg, #0d6efd, #6610f2);
      color: #fff !important;
      /* 🌟 FINAL FIX: Use padding-left to shift the content without breaking the container */
      padding-left: 22px; /* 18px (original) + 4px shift */
    }

    .sidebar .nav-item.active .nav-link {
      background: linear-gradient(90deg, #0d6efd, #6610f2);
      color: #fff !important;
      box-shadow: 0 3px 10px rgba(0,0,0,0.3);
      margin: 2px 5px; 
    }

    .sidebar-brand img {
      width: 200px;
      margin: 20px 0;
    }

    .topbar {
      background-color: #fff;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      border-bottom: 1px solid #dee2e6;
    }

    .topbar input.form-control {
      border-radius: 30px 0 0 30px;
      box-shadow: none;
    }

    .topbar .btn-dark {
      border-radius: 0 30px 30px 0;
    }

    .img-profile {
      width: 42px;
      height: 42px;
      object-fit: cover;
      border: 2px solid #0d6efd;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .dropdown-menu {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .sidebar-heading {
      text-transform: uppercase;
      font-size: 0.8rem;
      color: #adb5bd;
      letter-spacing: 1px;
      margin-left: 10px;
      margin-top: 10px;
    }

    .navbar-search .input-group input::placeholder {
      color: #6c757d;
      font-size: 0.9rem;
    }

  </style>
</head>

<body id="page-top">
  <div id="wrapper">

    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <img src="../admin/img/logo.png" alt="" width="240px">
      </a>

      <hr class="sidebar-divider my-0">

      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt me-2"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      <div class="sidebar-heading">Management</div>

      <li class="nav-item"><a class="nav-link" href="products.php"><i class="fas fa-box-open me-2"></i>Products</a></li>
      <li class="nav-item"><a class="nav-link" href="pending_products.php"><i class="fas fa-hourglass-half me-2"></i>Pending Products</a></li>
      <li class="nav-item"><a class="nav-link" href="approved_products.php"><i class="fas fa-check-circle me-2"></i>Approved Products</a></li>
      <li class="nav-item"><a class="nav-link" href="rejected_products.php"><i class="fas fa-times-circle me-2"></i>Rejected Products</a></li>
      <li class="nav-item"><a class="nav-link" href="completed_products.php"><i class="fas fa-clipboard-check me-2"></i>Completed Products</a></li>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-dark">
            <i class="fa fa-bars"></i>
          </button>

          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for...">
              <div class="input-group-append">
                <button class="btn btn-dark" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-700 small fw-semibold">
                  <?php echo $_SESSION['username']; ?>
                </span>
                <img class="img-profile rounded-circle" src="../admin/userpfp/<?php echo $_SESSION['userimage']?>">
              </a>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item text-danger fw-semibold" href="../auth/logout.php"
                  onclick="return confirm('Are you sure you want to logout?');">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>