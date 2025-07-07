<?php
// File: transaksi.php
require_once 'config/database.php';

$page_title = "Manajemen Transaksi";
include 'includes/header.php';

// Ambil data buku untuk dropdown
$buku_options_result = $conn->query("SELECT id_buku, judul, stok FROM buku WHERE stok > 0 ORDER BY judul ASC");

// Ambil data riwayat transaksi dengan JOIN ke tabel buku
$transaksi_result = $conn->query("
    SELECT t.id_transaksi, b.judul, t.jumlah_terjual, t.tanggal_transaksi 
    FROM transaksi t
    JOIN buku b ON t.id_buku = b.id_buku
    ORDER BY t.tanggal_transaksi DESC
");
?>

<h1>Manajemen Transaksi</h1>
<p class="lead">Catat penjualan buku. Stok akan otomatis berkurang setelah transaksi disimpan.</p>

<?php 
if(isset($_GET['status'])): 
    $status = $_GET['status'];
    $message = '';
    $alert_type = '';
    switch($status) {
        case 'sukses_tambah': $message = 'Transaksi berhasil dicatat dan stok buku telah diperbarui.'; $alert_type = 'success'; break;
        case 'gagal': $message = 'Terjadi kesalahan pada operasi.'; $alert_type = 'danger'; break;
        case 'gagal_stok': $message = 'Gagal! Jumlah penjualan melebihi stok yang tersedia.'; $alert_type = 'danger'; break;
    }
?>
<div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
    <?php echo $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row">
    <!-- Form Tambah Transaksi -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Catat Penjualan Baru</h5>
            </div>
            <div class="card-body">
                <form action="actions.php" method="POST">
                    <div class="mb-3">
                        <label for="id_buku" class="form-label">Pilih Buku</label>
                        <select class="form-select" id="id_buku" name="id_buku" required>
                            <option value="" selected disabled>-- Pilih Buku yang Terjual --</option>
                            <?php while($buku = $buku_options_result->fetch_assoc()): ?>
                                <option value="<?php echo $buku['id_buku']; ?>">
                                    <?php echo htmlspecialchars($buku['judul']) . " (Stok: " . $buku['stok'] . ")"; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Terjual</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="action" value="tambah_transaksi" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Transaksi -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Judul Buku</th>
                                <th>Jumlah</th>
                                <th>Tanggal & Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transaksi_result->num_rows > 0): 
                                while($row = $transaksi_result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['id_transaksi']; ?></td>
                                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                                    <td><?php echo $row['jumlah_terjual']; ?></td>
                                    <td><?php echo date('d M Y, H:i:s', strtotime($row['tanggal_transaksi'])); ?></td>
                                </tr>
                            <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada riwayat transaksi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
$conn->close();
?>
