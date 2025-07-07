<?php
// File: register.php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$page_title = "Register";
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // Password diambil langsung
    $nama_lengkap = trim($_POST['nama_lengkap']);

    if (empty($username) || empty($email) || empty($password) || empty($nama_lengkap)) {
        $error_message = "Semua field wajib diisi.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password minimal harus 6 karakter.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format email tidak valid.";
    } else {
        $stmt_check = $conn->prepare("SELECT id_pengguna FROM pengguna WHERE username = ? OR email = ?");
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $error_message = "Username atau email sudah terdaftar.";
        } else {
            // TIDAK ADA HASHING, LANGSUNG INSERT
            $stmt_insert = $conn->prepare("INSERT INTO pengguna (username, email, password, nama_lengkap) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $username, $email, $password, $nama_lengkap);

            if ($stmt_insert->execute()) {
                header("Location: login.php?status=sukses_register");
                exit();
            } else {
                $error_message = "Registrasi gagal. Silakan coba lagi.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - TokoBuku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .register-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
                <i class="bi bi-book-half fs-1 text-primary"></i>
                <h1 class="h3">Buat Akun Baru</h1>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    
                    <form action="register.php" method="POST">
                        <input type="hidden" name="action" value="register">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">Sudah punya akun? <a href="login.php">Login di sini</a></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
