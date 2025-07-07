<?php
// File: penjual.php
require_once 'config/database.php';

$page_title = "Manajemen Penjual";
include 'includes/header.php';

// Ambil semua data penjual
$penjual_result = $conn->query("SELECT * FROM penjual ORDER BY nama_penjual ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manajemen Penjual</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPenjualModal">
        <i class="bi bi-person-plus"></i> Tambah Penjual
    </button>
</div>

<?php 
if(isset($_GET['status'])): 
    $status = $_GET['status'];
    $message = '';
    $alert_type = '';
    switch($status) {
        case 'sukses_tambah': $message = 'Penjual berhasil ditambahkan.'; $alert_type = 'success'; break;
        case 'sukses_edit': $message = 'Data penjual berhasil diperbarui.'; $alert_type = 'success'; break;
        case 'sukses_hapus': $message = 'Penjual berhasil dihapus.'; $alert_type = 'success'; break;
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
                        <th>Nama Penjual</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($penjual_result->num_rows > 0): 
                        $i = 1;
                        while($row = $penjual_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_penjual']); ?></td>
                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($row['telepon']); ?></td>
                            <td><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editPenjualModal"
                                    data-bs-id="<?php echo $row['id_penjual']; ?>"
                                    data-bs-nama="<?php echo htmlspecialchars($row['nama_penjual']); ?>"
                                    data-bs-alamat="<?php echo htmlspecialchars($row['alamat']); ?>"
                                    data-bs-telepon="<?php echo htmlspecialchars($row['telepon']); ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="actions.php" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus penjual ini? Menghapus penjual akan mengatur relasinya di data buku menjadi NULL.');">
                                    <input type="hidden" name="id_penjual" value="<?php echo $row['id_penjual']; ?>">
                                    <button type="submit" name="action" value="hapus_penjual" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data penjual.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Penjual -->
<div class="modal fade" id="addPenjualModal" tabindex="-1" aria-labelledby="addPenjualModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actions.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPenjualModalLabel">Tambah Penjual Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_penjual" class="form-label">Nama Penjual</label>
                        <input type="text" class="form-control" id="nama_penjual" name="nama_penjual" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="action" value="tambah_penjual" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Penjual -->
<div class="modal fade" id="editPenjualModal" tabindex="-1" aria-labelledby="editPenjualModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actions.php" method="POST">
                <input type="hidden" name="id_penjual" id="edit_id_penjual">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenjualModalLabel">Edit Penjual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_penjual" class="form-label">Nama Penjual</label>
                        <input type="text" class="form-control" id="edit_nama_penjual" name="nama_penjual" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="edit_telepon" name="telepon" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="action" value="edit_penjual" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
$conn->close();
?>
