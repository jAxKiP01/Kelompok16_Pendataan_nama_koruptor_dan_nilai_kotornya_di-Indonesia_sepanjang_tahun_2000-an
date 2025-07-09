<?php
// File: actions.php
// Menangani semua logika backend (Create, Update, Delete)
// Menggunakan prepared statements untuk keamanan maksimal

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        // =======================================================
        // AKSI UNTUK BUKU
        // =======================================================
        case 'tambah_buku':
            // Menggunakan Stored Procedure sp_tambah_buku
            $judul = $_POST['judul'];
            $penulis = $_POST['penulis'];
            $penerbit = $_POST['penerbit'];
            $tahun = $_POST['tahun_terbit'] ?: null;
            $stok = $_POST['stok'];
            $harga = $_POST['harga'];
            $id_penjual = $_POST['id_penjual'] ?: null;

            $stmt = $conn->prepare("CALL tambah_buku(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiidi", $judul, $penulis, $penerbit, $tahun, $stok, $harga, $id_penjual);
            
            if ($stmt->execute()) {
                header("Location: buku.php?status=sukses_tambah");
            } else {
                header("Location: buku.php?status=gagal");
            }
            $stmt->close();
            break;

        case 'edit_buku':
            $id_buku = $_POST['id_buku'];
            $judul = $_POST['judul'];
            $penulis = $_POST['penulis'];
            $penerbit = $_POST['penerbit'];
            $tahun = $_POST['tahun_terbit'] ?: null;
            $stok = $_POST['stok'];
            $harga = $_POST['harga'];
            $id_penjual = $_POST['id_penjual'] ?: null;

            $stmt = $conn->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, stok=?, harga=?, id_penjual=? WHERE id_buku=?");
            $stmt->bind_param("sssiidii", $judul, $penulis, $penerbit, $tahun, $stok, $harga, $id_penjual, $id_buku);

            if ($stmt->execute()) {
                header("Location: buku.php?status=sukses_edit");
            } else {
                header("Location: buku.php?status=gagal");
            }
            $stmt->close();
            break;

        case 'hapus_buku':
            $id_buku = $_POST['id_buku'];
            $stmt = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
            $stmt->bind_param("i", $id_buku);

            if ($stmt->execute()) {
                header("Location: buku.php?status=sukses_hapus");
            } else {
                header("Location: buku.php?status=gagal");
            }
            $stmt->close();
            break;

        // =======================================================
        // AKSI UNTUK PENJUAL (Anda bisa membuat file penjual.php)
        // =======================================================
        case 'tambah_penjual':
            $penjual = $_POST['nama_penjual'];
            $alamat = $_POST['alamat'];
            $telepon = $_POST['telepon'];

            $stmt = $conn->prepare("CALL tambah_penjual(?, ?, ?)");
            $stmt->bind_param("sss", $penjual, $alamat, $telepon);
            
            if ($stmt->execute()) {
                header("Location: penjual.php?status=sukses_tambah");
            } else {
                header("Location: penjual.php?status=gagal");
            }
            break;

        // =======================================================
        // AKSI UNTUK TRANSAKSI (untuk demo trigger)
        // =======================================================
        case 'tambah_transaksi':
            $id_buku = $_POST['id_buku'];
            $jumlah = $_POST['jumlah'];

            // Cek stok dulu sebelum insert
            $check_stock_stmt = $conn->prepare("SELECT stok FROM buku WHERE id_buku = ?");
            $check_stock_stmt->bind_param("i", $id_buku);
            $check_stock_stmt->execute();
            $result = $check_stock_stmt->get_result();
            $buku = $result->fetch_assoc();

            if ($buku && $buku['stok'] >= $jumlah) {
                $stmt = $conn->prepare("INSERT INTO transaksi (id_buku, jumlah_terjual) VALUES (?, ?)");
                $stmt->bind_param("ii", $id_buku, $jumlah);
                if ($stmt->execute()) {
                    header("Location: transaksi.php?status=sukses_tambah");
                } else {
                    header("Location: transaksi.php?status=gagal");
                }
                $stmt->close();
            } else {
                header("Location: transaksi.php?status=gagal_stok");
            }
            $check_stock_stmt->close();
            break;

        default:
            // Jika tidak ada aksi yang cocok, kembali ke halaman utama
            header("Location: index.php");
            break;
    }
} else {
    // Jika diakses langsung, kembali ke halaman utama
    header("Location: index.php");
}

$conn->close();
exit();
?>
