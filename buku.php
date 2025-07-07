<?php
// File: buku.php
require_once 'config/database.php';

$page_title = "Manajemen Buku";
include 'includes/header.php';

// Ambil data penjual untuk dropdown
$penjual_result = $conn->query("SELECT id_penjual, nama_penjual FROM penjual ORDER BY nama_penjual");

// Ambil data buku dari VIEW v_buku_lengkap
$buku_result = $conn->query("SELECT * FROM v_buku_lengkap ORDER BY judul ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manajemen Buku</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBukuModal">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </button>
</div>

<?php 
if(isset($_GET['status'])): 
    $status = $_GET['status'];
    $message = '';
    $alert_type = '';
    switch($status) {
        case 'sukses_tambah': $message = 'Buku berhasil ditambahkan.'; $alert_type = 'success'; break;
        case 'sukses_edit': $message = 'Data buku berhasil diperbarui.'; $alert_type = 'success'; break;
        case 'sukses_hapus': $message = 'Buku berhasil dihapus.'; $alert_type = 'success'; break;
        case 'gagal': $message = 'Terjadi kesalahan pada operasi.'; $alert_type = 'danger'; break;
    }
?>
<div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
    <?php echo $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Penjual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($buku_result->num_rows > 0): 
                        $i = 1;
                        while($row = $buku_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['judul']); ?></td>
                            <td><?php echo htmlspecialchars($row['penulis']); ?></td>
                            <td><?php echo htmlspecialchars($row['penerbit']); ?></td>
                            <td><?php echo $row['tahun_terbit']; ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_penjual'] ?? 'N/A'); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editBukuModal"
                                    data-bs-id="<?php echo $row['id_buku']; ?>"
                                    data-bs-judul="<?php echo htmlspecialchars($row['judul']); ?>"
                                    data-bs-penulis="<?php echo htmlspecialchars($row['penulis']); ?>"
                                    data-bs-penerbit="<?php echo htmlspecialchars($row['penerbit']); ?>"
                                    data-bs-tahun="<?php echo $row['tahun_terbit']; ?>"
                                    data-bs-stok="<?php echo $row['stok']; ?>"
                                    data-bs-harga="<?php echo $row['harga']; ?>"
                                    data-bs-idpenjual="<?php echo $row['id_penjual']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="actions.php" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus buku ini?');">
                                    <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                                    <button type="submit" name="action" value="hapus_buku" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data buku.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="addBukuModal" tabindex="-1" aria-labelledby="addBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="actions.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBukuModalLabel">Tambah Buku Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" min="1800" max="<?php echo date('Y'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required min="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required min="0" step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_penjual" class="form-label">Penjual</label>
                            <select class="form-select" id="id_penjual" name="id_penjual">
                                <option value="">-- Pilih Penjual --</option>
                                <?php while($p = $penjual_result->fetch_assoc()): ?>
                                    <option value="<?php echo $p['id_penjual']; ?>"><?php echo htmlspecialchars($p['nama_penjual']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="action" value="tambah_buku" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Buku -->
<div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="editBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="actions.php" method="POST">
                <input type="hidden" name="id_buku" id="edit_id_buku">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBukuModalLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="edit_penulis" name="penulis" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="edit_penerbit" name="penerbit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tahun" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="edit_tahun" name="tahun_terbit" min="1800" max="<?php echo date('Y'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="edit_stok" name="stok" required min="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="edit_harga" name="harga" required min="0" step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_id_penjual" class="form-label">Penjual</label>
                            <select class="form-select" id="edit_id_penjual" name="id_penjual">
                                <option value="">-- Pilih Penjual --</option>
                                <?php 
                                // Reset pointer dan loop lagi
                                $penjual_result->data_seek(0);
                                while($p = $penjual_result->fetch_assoc()): ?>
                                    <option value="<?php echo $p['id_penjual']; ?>"><?php echo htmlspecialchars($p['nama_penjual']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="action" value="edit_buku" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
$conn->close();
?>
