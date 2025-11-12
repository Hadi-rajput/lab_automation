<?php
session_start();
include '../config/db_connect.php';
if (!isset($_SESSION['username']) || $_SESSION['userrole'] == 1 || $_SESSION['userrole'] == 2) {
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

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/09308f2a9c.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #0d0d0d, #1e1e2f);
        }

        .sidebar .nav-item .nav-link {
            color: #dcdcdc;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
            border-radius: 10px;
        }

        .sidebar .nav-item.active .nav-link {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        }

        /* Sidebar brand (logo) */
        .sidebar-brand img {
            width: 180px;
            filter: drop-shadow(0 0 10px rgba(0, 123, 255, 0.7));
            margin-top: 15px;
        }

        /* Topbar */
        .topbar {
            background: linear-gradient(90deg, #ffffff, #f1f3f8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .topbar .form-control {
            border-radius: 30px;
        }

        .topbar .btn-dark {
            border-radius: 30px;
            background: linear-gradient(90deg, #007bff, #6610f2);
            border: none;
        }

        .topbar .btn-dark:hover {
            opacity: 0.9;
        }

        /* User profile */
        .img-profile {
            width: 40px;
            height: 40px;
            border: 2px solid #007bff;
            object-fit: cover;
        }

        .dropdown-menu {
            border-radius: 10px;
            border: none;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Collapsible items */
        .collapse-inner a.collapse-item {
            transition: all 0.3s;
            border-radius: 8px;
        }

        .collapse-inner a.collapse-item:hover {
            background-color: #007bff;
            color: #fff;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #007bff, #6610f2);
            border-radius: 10px;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
               <img src="img/logo.png" alt="" width="100px">
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Management</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts"
                    aria-expanded="false" aria-controls="collapseProducts">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Products</span>
                </a>
                <div id="collapseProducts" class="collapse" aria-labelledby="headingProducts"
                    data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage Products:</h6>
                        <a class="collapse-item" href="view-products.php">View Products</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseManageUsers"
                    aria-expanded="false" aria-controls="collapseManageUsers">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Manage Users</span>
                </a>
                <div id="collapseManageUsers" class="collapse" aria-labelledby="headingManageUsers"
                    data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Admin Controls:</h6>
                        <a class="collapse-item" href="view-users.php">View All Users</a>
                         <a class="collapse-item" href="add_tester.php">Add Tester</a>
                    </div>
                </div>
            </li>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['username']; ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="userpfp/<?php echo $_SESSION['userimage']; ?>">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../auth/logout.php"
                                    onclick="return confirm('Are you sure you want to logout?');">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
