<?php
session_start();
include 'koneksi.php';

$status_akun = 0; 
$is_loggedin = false;
$nama_user = "Tamu";

if (isset($_SESSION['user_id'])) {
    $id_user = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id_user'");
    
    if ($row = mysqli_fetch_assoc($query)) {
        $status_akun = $row['status'];
        $nama_user = $row['nama_lengkap'];
        $is_loggedin = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Tukang - Benahin Yuk</title>
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
                <?php if ($is_loggedin): ?>
                    <span style="font-weight: 600; color: #1f2937; margin-right: 15px;">
                        Halo, <?= htmlspecialchars($nama_user) ?>!
                    </span>
                    <a href="logout.php" class="btn btn-orange" style="background-color: #ef4444;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Login</a>
                    <a href="https://forms.gle/c4oXptnLeZgzfuVr9" target="_blank" class="btn btn-orange">Daftar  Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="section directory-page">
        <div class="container">
            
            <?php if ($status_akun == 0): ?>

                <div class="directory-header">
                    
                    <?php if ($is_loggedin): ?>
                        <h2 class="section-title" style="margin-bottom: 10px;">Status: Menunggu Verifikasi</h2>
                        <div style="background: #fff7ed; padding: 15px; border-radius: 8px; display: inline-block;">
                            <p style="color: #ea580c; font-weight: bold;">
                                <i class="fa-regular fa-clock"></i> Admin sedang mengecek bukti pembayaran Anda.
                            </p>
                            <p style="font-size: 0.9rem; margin-top: 5px;">
                                Kontak tukang akan terbuka otomatis setelah Admin mengaktifkan akun Anda.
                                <a href="https://wa.me/6281234567890" target="_blank">Chat Admin</a>
                            </div>
                    <?php else: ?>
                        <h2 class="section-title" style="margin-bottom: 10px;">Direktori Tukang Terverifikasi</h2>
                        <p class="subtitle">Kontak dikunci. Silakan daftar untuk membuka akses selamanya.</p>
                        
                        <a href="register.php" class="btn btn-blue-filter" style="text-decoration: none; display: inline-block; margin-top: 10px;">
                             Daftar Member Premium Sekarang
                        </a>
                    <?php endif; ?>

                </div>

                <div class="grid-3">
                    <div class="card tukang-card">
                        <div class="blur-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Pak+B&background=random&size=128" class="blur-img">
                            <div class="lock-overlay"><i class="fa-solid fa-lock"></i></div>
                        </div>
                        <h3>Pak A***</h3>
                        <p class="service-type">Servis Kipas & Elektronik</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        
                        <?php if(!$is_loggedin): ?>
<button type="button" class="btn btn-locked" onclick="bukaModal()">
    <i class="fa-solid fa-lock"></i> Daftar untuk Buka
</button>
                        <?php else: ?>
                            <button class="btn btn-locked"><i class="fa-solid fa-lock"></i> Menunggu Verifikasi</button>
                        <?php endif; ?>
                    </div>

                     <div class="card tukang-card">
                        <div class="blur-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Pak+A&background=random&size=128" class="blur-img">
                            <div class="lock-overlay"><i class="fa-solid fa-lock"></i></div>
                        </div>
                        <h3>Pak A***</h3>
                        <p class="service-type">Tukang Pintu & Perbaikan Rumah</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        
                        <?php if(!$is_loggedin): ?>
<button type="button" class="btn btn-locked" onclick="bukaModal()">
    <i class="fa-solid fa-lock"></i> Daftar untuk Buka
</button>
                        <?php else: ?>
                            <button class="btn btn-locked"><i class="fa-solid fa-lock"></i> Menunggu Verifikasi</button>
                        <?php endif; ?>
                    </div>

                    <div class="card tukang-card">
                        <div class="blur-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Pak+D&background=random&size=128" class="blur-img">
                            <div class="lock-overlay"><i class="fa-solid fa-lock"></i></div>
                        </div>
                        <h3>Pak A***</h3>
                        <p class="service-type">Service AC, Kulkas, Dispenser</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                        
                        <?php if(!$is_loggedin): ?>
<button type="button" class="btn btn-locked" onclick="bukaModal()">
    <i class="fa-solid fa-lock"></i> Daftar untuk Buka
</button>
                        <?php else: ?>
                            <button class="btn btn-locked"><i class="fa-solid fa-lock"></i> Menunggu Verifikasi</button>
                        <?php endif; ?>
                    </div>
                </div>


            <?php else: ?>

                <div class="directory-header">
                    <h2 class="section-title">Direktori Tukang Terverifikasi</h2>
                    <p class="subtitle" style="color: #166534; font-weight: bold;">
                        ✅ Akun Premium Aktif. Silakan hubungi tukang pilihan Anda.
                    </p>
                </div>

                <div class="grid-3">
                    <div class="card tukang-card">
                        <div class="avatar-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Pak+Budi&background=0D8ABC&color=fff&size=128" class="avatar-img">
                        </div>
                        <h3>Pak Ahmad</h3>
                        <p class="service-type">Service AC, Kulkas, Dispenser</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <div class="tag-pill">Profesional & Kerja Rapih</div>
                        
                        <div class="info-details">
                            <div class="info-row"><span class="label">Harga:</span> <span class="value">Rp 12rb - 65rb</span></div>
                            <div class="info-row"><span class="label">Area:</span> <span class="value">Semua Area Jakarta Selatan & Depok</span></div>
                        </div>

                        <div class="action-buttons">
                            <a href="https://wa.me/6281311613654" target="_blank" class="btn-wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                            <a href="tel:081311613654" class="btn-call"><i class="fa-solid fa-phone"></i> Telepon</a>
                        </div>
                    </div>

                    <div class="card tukang-card">
                        <div class="avatar-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Pak+Agus&background=random&size=128" class="avatar-img">
                        </div>
                        <h3>Pak Anto</h3>
                        <p class="service-type">Tukang Pintu & Perbaikan Rumah</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <div class="tag-pill">Sangat Cepat Respon</div>
                        
                        <div class="info-details">
                            <div class="info-row"><span class="label">Harga:</span> <span class="value">Rp 50rb - 100rb</span></div>
                            <div class="info-row"><span class="label">Area:</span> <span class="value">Pondok Cina</span></div>
                        </div>

                        <div class="action-buttons">
                            <a href="https://wa.me/62895332572882" target="_blank" class="btn-wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                            <a href="tel:0895332572882" class="btn-call"><i class="fa-solid fa-phone"></i> Telepon</a>
                        </div>
                    </div>

                    <div class="card tukang-card">
                        <div class="avatar-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Pak+Dedi&background=random&size=128" class="avatar-img">
                        </div>
                        <h3>Pak Aziz</h3>
                        <p class="service-type">Servis Kipas & Elektronik</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                        <div class="tag-pill">Harga Jujur, Cepat Respon</div>
                        
                        <div class="info-details">
                            <div class="info-row"><span class="label">Harga:</span> <span class="value">Rp 40rb - 60rb</span></div>
                            <div class="info-row"><span class="label">Area:</span> <span class="value"></span>Kukusan & Beji</div>
                        </div>

                        <div class="action-buttons">
                            <a href="https://wa.me/62812345678" target="_blank" class="btn-wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                            <a href="tel:0812345678" class="btn-call"><i class="fa-solid fa-phone"></i> Telepon</a>
                        </div>
                    </div>

                </div>

            <?php endif; ?>
            </div>
    </section>

    <footer>
        <div class="container footer-content">
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
    
    <div id="premiumModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fa-solid fa-crown"></i>
            </div>
            <h3>Akses Premium Diperlukan</h3>
            <p>Maaf, kontak tukang ini dikunci khusus untuk Member Premium. Biaya pendaftaran hanya <strong>Rp 15.000</strong> seumur hidup.</p>
            
            <div class="modal-buttons">
                <button onclick="tutupModal()" class="btn-cancel">Nanti Dulu</button>
                <!-- <a href="register.php" class="btn-confirm">Daftar Sekarang</a> -->
                <a href="https://forms.gle/c4oXptnLeZgzfuVr9" target="_blank" class="btn-confirm">Daftar Sekarang</a>

            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            display: none; 
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); 
            z-index: 9999;
            align-items: center;     
            justify-content: center; 
        }
        
        .modal-overlay.active { display: flex; animation: fadeIn 0.3s; }

        .modal-box {
            background: white; padding: 30px; border-radius: 15px;
            width: 90%; max-width: 400px; text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .modal-icon {
            width: 60px; height: 60px; background: #fff7ed; color: #f97316;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 15px auto;
        }
        
        .modal-buttons { display: flex; gap: 10px; margin-top: 20px; }
        .btn-confirm { background: #f97316; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; flex: 1; font-weight: bold; }
        .btn-cancel { background: white; border: 1px solid #ddd; color: #555; padding: 10px 20px; border-radius: 8px; cursor: pointer; flex: 1; }

        @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    </style>

    <script>
        function bukaModal() {
            document.getElementById('premiumModal').classList.add('active');
        }
        
        function tutupModal() {
            document.getElementById('premiumModal').classList.remove('active');
        }

        window.onclick = function(event) {
            let modal = document.getElementById('premiumModal');
            if (event.target == modal) {
                tutupModal();
            }
        }
    </script>
    
</body>
</html>