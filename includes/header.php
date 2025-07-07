<?php
// File: includes/header.php
// Memulai session di setiap halaman yang menggunakan header ini
session_start();

// Cek apakah pengguna sudah login.
// Jika tidak ada session user_id, dan halaman yang diakses bukan login/register,
// maka redirect ke halaman login.
$current_page_basename = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['user_id']) && $current_page_basename != 'login.php' && $current_page_basename != 'register.php') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Dashboard Toko Buku'; ?></title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 280px;
            z-index: 100;
            background-color: #343a40;
            padding-top: 1rem;
        }
        .sidebar .nav-link {
            color: #c2c7d0;
            font-size: 1.1rem;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
        }
        .sidebar .nav-link .bi {
            margin-right: 0.8rem;
        }
        .main-content {
            margin-left: 280px;
        }
        .top-navbar {
            padding: 0.8rem 2rem;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
        }
        .content-wrapper {
            padding: 2rem;
        }
        .card-icon {
            font-size: 3rem;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="main-content w-100">
            <!-- Top Navbar -->
            <nav class="top-navbar d-flex justify-content-end">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
            
            <!-- Main Page Content -->
            <div class="content-wrapper">
