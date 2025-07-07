<?php
// File: index.php (Dashboard)
require_once 'config/database.php';

$page_title = "Dashboard";
include 'includes/header.php';

// Query untuk Agregat (COUNT, SUM, MAX, MIN)
// 1. Jumlah Judul Buku
$result_total_buku = $conn->query("SELECT COUNT(id_buku) AS total_buku FROM buku");
$total_buku = $result_total_buku->fetch_assoc()['total_buku'];

// 2. Jumlah Total Stok Semua Buku
$result_total_stok = $conn->query("SELECT SUM(stok) AS total_stok FROM buku");
$total_stok = $result_total_stok->fetch_assoc()['total_stok'];

// 3. Jumlah Penjual
$result_total_penjual = $conn->query("SELECT COUNT(id_penjual) AS total_penjual FROM penjual");
$total_penjual = $result_total_penjual->fetch_assoc()['total_penjual'];

// 4. Nilai Aset Buku (SUM dari harga * stok)
$result_nilai_aset = $conn->query("SELECT SUM(harga * stok) AS nilai_aset FROM buku");
$nilai_aset = $result_nilai_aset->fetch_assoc()['nilai_aset'];

// 5. Buku Termahal (MAX)
$result_buku_mahal = $conn->query("SELECT judul, harga FROM buku ORDER BY harga DESC LIMIT 1");
$buku_mahal = $result_buku_mahal->fetch_assoc();

// 6. Buku Termurah (MIN)
$result_buku_murah = $conn->query("SELECT judul, harga FROM buku ORDER BY harga ASC LIMIT 1");
$buku_murah = $result_buku_murah->fetch_assoc();

?>

<h1 class="mb-4">Dashboard</h1>

<div class="row">
    <!-- Card Total Judul Buku -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Judul Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_buku; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-book card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Total Stok Buku -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Stok Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_stok); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-stack card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Total Penjual -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Penjual</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_penjual; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-vcard card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Nilai Aset -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Nilai Aset Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($nilai_aset, 2, ',', '.'); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cash-coin card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Harga Buku</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Buku Termahal: <strong><?php echo htmlspecialchars($buku_mahal['judul']); ?></strong></span>
                    <span class="badge bg-danger">Rp <?php echo number_format($buku_mahal['harga'], 2, ',', '.'); ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Buku Termurah: <strong><?php echo htmlspecialchars($buku_murah['judul']); ?></strong></span>
                    <span class="badge bg-success">Rp <?php echo number_format($buku_murah['harga'], 2, ',', '.'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include 'includes/footer.php';
$conn->close();
?>
