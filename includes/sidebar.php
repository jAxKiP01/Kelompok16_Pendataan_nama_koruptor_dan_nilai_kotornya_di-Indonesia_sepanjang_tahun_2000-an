<?php
// File: includes/sidebar.php
// Sidebar navigasi
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar d-flex flex-column p-3 text-white bg-dark">
    <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-book-half fs-4 me-2"></i>
        <span class="fs-4">TokoBuku</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" aria-current="page">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="buku.php" class="nav-link <?php echo ($current_page == 'buku.php') ? 'active' : ''; ?>">
                <i class="bi bi-book"></i> Buku
            </a>
        </li>
        <li>
            <a href="penjual.php" class="nav-link <?php echo ($current_page == 'penjual.php') ? 'active' : ''; ?>">
                <i class="bi bi-person-vcard"></i> Penjual
            </a>
        </li>
        <li>
            <a href="transaksi.php" class="nav-link <?php echo ($current_page == 'transaksi.php') ? 'active' : ''; ?>">
                <i class="bi bi-cart-check"></i> Transaksi
            </a>
        </li>
    </ul>
    <hr>
    <div class="text-center text-muted small">
        &copy; <?php echo date('Y'); ?> TokoBuku Pro
    </div>
</div>