<?php
// File: config/database.php
// Konfigurasi koneksi database
// Menggunakan mysqli untuk koneksi yang lebih aman dan modern

// Detail koneksi
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Ganti dengan username database Anda
define('DB_PASS', '');     // Ganti dengan password database Anda
define('DB_NAME', 'toko_buku_db'); // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Set character set ke utf8mb4 untuk mendukung karakter internasional
$conn->set_charset("utf8mb4");

?>
