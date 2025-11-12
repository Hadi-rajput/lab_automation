<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['username']) || $_SESSION['userrole'] != 2) {
    echo "<script>window.location.href='../auth/login.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tester Control Panel</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/09308f2a9c.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6fb;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #1a1a2e, #16213e);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-item .nav-link {
            color: #cfd2ff;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-item .nav-link:hover {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: #fff;
            border-radius: 10px;
            transform: translateX(3px);
        }

        .sidebar .nav-item.active .nav-link {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        }

        /* Sidebar brand */
        .sidebar-brand img {
            width: 170px;
            filter: drop-shadow(0 0 12px rgba(102, 16, 242, 0.7));
            margin-top: 15px;
        }

        /* Topbar */
        .topbar {
            background: linear-gradient(90deg, #ffffff, #eef1f8);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-bottom: 2px solid rgba(0, 123, 255, 0.15);
        }

        .topbar .form-control {
            border-radius: 30px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .topbar .btn-dark {
            border-radius: 30px;
            background: linear-gradient(90deg, #007bff, #6610f2);
            border: none;
            color: #fff;
            transition: 0.3s ease;
        }

        .topbar .btn-dark:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        /* User profile */
        .img-profile {
            width: 42px;
            height: 42px;
            border: 2px solid #6610f2;
            object-fit: cover;
            box-shadow: 0 0 8px rgba(102, 16, 242, 0.3);
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 10px;
            border: none;
            box-shadow: 0px 5px 18px rgba(0, 0, 0, 0.1);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #007bff, #6610f2);
            border-radius: 10px;
        }

        /* Sidebar Heading */
        .sidebar-heading {
            color: #9fa8da;
            font-size: 0.8rem;
            text-transform: uppercase;
            margin-top: 1rem;
            letter-spacing: 1px;
        }

        /* Animation */
        .nav-link i {
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <img src="../admin/img/logo.png" alt="Lab_Automation Logo">
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Review Tasks</div>

            <li class="nav-item">
                <a class="nav-link" href="assigned_products.php">
                    <i class="fas fa-tasks fa-sm fa-fw me-2"></i>
                    <span>Assigned Products</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="completed_products.php">
                    <i class="fas fa-check-circle fa-sm fa-fw me-2"></i>
                    <span>Completed Reviews</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <form class="d-none d-sm-inline-block form-inline ms-auto me-3 my-2 my-md-0 mw-100 navbar-search">
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

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-700 small fw-semibold">
                                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="../admin/userpfp/<?php echo htmlspecialchars($_SESSION['userimage']); ?>">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item text-danger fw-semibold" href="../auth/logout.php"
                                    onclick="return confirm('Are you sure you want to logout?');">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
