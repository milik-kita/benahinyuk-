<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama_lengkap'];
            $_SESSION['status'] = $user['status']; 

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Benahin Yuk</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" style="text-decoration: none;">
                <div class="logo">
                    <i class="fa-solid fa-wrench"></i> benahinyuk
                </div>
            </a>
            <div class="nav-right">
                <a href="login.php" class="nav-link" style="color: #1a73e8; font-weight: 600;">Login</a>
                <!-- <a href="register.php" class="btn btn-orange">Daftar Sekarang (Rp 15.000)</a> -->
                <a href="https://forms.gle/c4oXptnLeZgzfuVr9" target="_blank" class="btn btn-orange">Daftar Sekarang</a>

            </div>
        </div>
    </nav>

    <section class="login-section">
        <div class="login-container reveal">
            <div class="login-card">
                <h2>Login</h2>
                <p class="subtitle">Masuk ke akun premium Anda</p>

                <?php if(isset($error)): ?>
                    <p style="color: red; background: #fee2e2; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        <?= $error ?>
                    </p>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="email@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-blue-full">Login</button>
                </form>

                <div class="login-footer">
                    <p>Belum punya akun?</p>
                    <a href="register.php" class="link-blue">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <footer>
        <div class="container footer-content reveal">
            <div class="footer-col">
                <div class="logo footer-logo">
                    <i class="fa-solid fa-wrench"></i> benahinyuk
                </div>
                <p>Database tukang servis jujur & terverifikasi untuk mahasiswa.</p>
            </div>
            <div class="footer-col">
                <h4>Menu</h4>
                <ul class="footer-links">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="dashboard.php">Direktori</a></li>
                    <li><a href="tentang-kami.php">Tentang Kami</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <p>WhatsApp: 0812-YYYY-YYYY</p>
                <p>Email: info@benahinyuk.com</p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 benahinyuk. Semua hak dilindungi.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>