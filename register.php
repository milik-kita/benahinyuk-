<?php
include 'koneksi.php';

// Error logging function
function logUploadError($message) {
    $log_file = "logs/upload_errors.log";
    if (!is_dir("logs")) {
        mkdir("logs", 0755, true);
    }
    $timestamp = date("Y-m-d H:i:s");
    $log_message = "[$timestamp] $message\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

// Ensure uploads directory exists and has proper permissions
if (!is_dir("uploads")) {
    mkdir("uploads", 0755, true);
}

if (isset($_POST['daftar'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('❌ Email sudah terdaftar! Gunakan email lain.');</script>";
    } else if (empty($_FILES['bukti']['name'])) {
        echo "<script>alert('❌ Harap upload bukti pembayaran!');</script>";
    } else {
        // Handle file upload
        $nama_file = $_FILES['bukti']['name'];
        $tmp_file = $_FILES['bukti']['tmp_name'];
        $ukuran_file = $_FILES['bukti']['size'];
        $file_error = $_FILES['bukti']['error'];

        // Validate file upload
        $max_size = 5 * 1024 * 1024; // 5MB
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if ($file_error !== UPLOAD_ERR_OK) {
            $error_msg = "Upload Error Code: $file_error";
            logUploadError("$email - $error_msg");
            echo "<script>alert('❌ Gagal upload: Error Code $file_error');</script>";
        } else if ($ukuran_file > $max_size) {
            $error_msg = "$email - File terlalu besar (" . ($ukuran_file / 1024 / 1024) . "MB)";
            logUploadError($error_msg);
            echo "<script>alert('❌ File terlalu besar! Maksimal 5MB.');</script>";
        } else if (!in_array($file_ext, $allowed_ext)) {
            $error_msg = "$email - Format file tidak didukung: $file_ext";
            logUploadError($error_msg);
            echo "<script>alert('❌ Format file tidak didukung! Gunakan JPG, PNG, atau GIF.');</script>";
        } else {
            $nama_baru = time() . "_" . basename($nama_file);
            $path = "uploads/" . $nama_baru;

            if (move_uploaded_file($tmp_file, $path)) {
                // Chmod the uploaded file
                chmod($path, 0644);

                $sql = "INSERT INTO users (nama_lengkap, email, whatsapp, password, bukti_bayar, status) 
                        VALUES ('$nama', '$email', '$wa', '$password', '$nama_baru', 0)";
                
                if (mysqli_query($conn, $sql)) {
                    logUploadError("$email - ✅ Upload Berhasil: $nama_baru");
                    
                    $nomor_admin = "62895712883434"; 
                    $pesan = "Halo Admin, saya baru saja mendaftar di BenahinYuk a.n *$nama*. Saya sudah upload bukti transfer, mohon segera diaktifkan akun saya.";
                    $pesan_encoded = urlencode($pesan);
                    $link_wa = "https://wa.me/$nomor_admin?text=$pesan_encoded";

                    echo "<script>
                        alert('✅ Pendaftaran Berhasil! \\n\\nKlik OK untuk langsung konfirmasi ke WhatsApp Admin.');
                        window.location.href = '$link_wa';
                    </script>";
                } else {
                    $error_msg = "$email - Database Error: " . mysqli_error($conn);
                    logUploadError($error_msg);
                    unlink($path); // Delete uploaded file if DB insert fails
                    echo "<script>alert('❌ Error Database: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                $error_msg = "$email - Move file failed. Tmp: $tmp_file, Path: $path, Writable: " . (is_writable("uploads") ? "Yes" : "No");
                logUploadError($error_msg);
                echo "<script>alert('❌ Gagal upload gambar. Hubungi admin jika masalah berlanjut.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - Benahin Yuk</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                <a href="login.php" class="nav-link">Login</a>
                <button class="btn btn-orange" style="opacity: 0.5; cursor: default;">Daftar Sekarang</button>
                
            </div>
        </div>
    </nav>

    <section class="login-section"> 
        <div class="login-container reveal">
            
            <div class="register-card">
                <div class="reg-header">
                    <h2>Daftar Member benahinyuk</h2>
                    <p>Akses Premium Selamanya. Cukup Bayar Satu Kali:</p>
                    <div class="price-tag">Rp 15.000</div>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="email@example.com" required>
                    </div>

                    <div class="form-group">
                        <label>Nomor WhatsApp</label>
                        <input type="tel" name="whatsapp" placeholder="0812 XXXX XXXX" required>
                        <small style="color: #6b7280; font-size: 0.8rem;">Penting untuk konfirmasi pembayaran</small>
                    </div>

                    <div class="form-group">
                        <label>Buat Password</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>

                    <hr class="divider">

                    <div class="payment-section">
                        <h4>Instruksi Pembayaran</h4>
                        <div class="payment-box">
                            <p class="pay-instruction-text">Silakan transfer Rp 15.000 ke salah satu rekening berikut:</p>
                            
                            <div class="payment-method">
                                <div>
                                    <h5>OVO</h5>
                                    <p class="account-number">089685789410</p>
                                    <p class="account-name">a.n. Najwa Putri S</p>
                                </div>
                            </div>

                            <div class="payment-method">
                                <div>
                                    <h5>BANK JASA JAKARTA</h5>
                                    <p class="account-number">10033668649</p>
                                    <p class="account-name">a.n. Najwa Putri S</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Upload Bukti Transfer</label>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" name="bukti" id="fileInput" hidden accept="image/*">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                            <p id="uploadText">Klik untuk upload atau drag & drop</p>
                            <span class="upload-sub">PNG, JPG hingga 5MB</span>
                        </div>
                    </div>

                    <button type="submit" name="daftar" class="btn btn-blue-full">Daftar Sekarang</button>
                </form>

                <div class="wa-confirm">
                    <p>Setelah klik "Daftar", konfirmasi pembayaran Anda ke WhatsApp Admin:</p>
                    <a href="#">0895712883434</a>
                </div>

                <div class="disclaimer-box">
                    <p><strong>Disclaimer:</strong> Akun Anda akan kami aktifkan secara manual dalam 1x24 jam setelah konfirmasi.</p>
                </div>

            </div>
        </div>
    </section>

    <footer>
        <div class="copyright">
            <p>&copy; 2025 benahinyuk. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>