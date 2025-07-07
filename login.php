<?php
// File: login.php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$page_title = "Login";
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error_message = "Username dan password tidak boleh kosong.";
    } else {
        // Mengambil password plain text dari database
        $stmt = $conn->prepare("SELECT id_pengguna, username, password FROM pengguna WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verifikasi password dengan perbandingan string biasa
            if ($password === $user['password']) {
                // Login berhasil, set session
                $_SESSION['user_id'] = $user['id_pengguna'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Username atau password salah.";
            }
        } else {
            $error_message = "Username atau password salah.";
        }
        $stmt->close();
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
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="col-md-5 col-lg-4">
            <div class="text-center mb-4">
                <i class="bi bi-book-half fs-1 text-primary"></i>
                <h1 class="h3">TokoBuku Pro</h1>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title text-center mb-4">Silakan Login</h5>
                    
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses_register'): ?>
                        <div class="alert alert-success">Registrasi berhasil! Silakan login.</div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">Belum punya akun? <a href="register.php">Daftar di sini</a></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
