<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benahin Yuk - Jasa Servis Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="container nav-container">
            <div class="logo">
                <i class="fa-solid fa-wrench"></i> benahinyuk
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn btn-orange" style="background-color: #ef4444;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Login</a>
                    <!-- <a href="register.php" class="btn btn-orange">Daftar Sekarang (Rp 15.000)</a> -->
                    <a href="https://forms.gle/c4oXptnLeZgzfuVr9" target="_blank" class="btn btn-orange">Daftar Sekarang (Rp 15.000)</a>

                <?php endif; ?>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container hero-content reveal">
            <h1>Kipas Rusak? Setrika Mati?<br>Jangan Panik!</h1>
            <p>Temukan Database Tukang Servis Jujur & Terverifikasi<br>di Area Kosan UI (Beji, Kukusan, Pocin).</p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-orange btn-large">Lihat Direktori Tukang</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn btn-orange btn-large">Lihat Daftar Tukang (Akses Premium)</a>
            <?php endif; ?>
            
        </div>
    </header>

    <section class="section features">
        <div class="container">
            <h2 class="section-title reveal">Kenapa benahinyuk?</h2>
            <div class="grid-4 reveal">
                <div class="card feature-card">
                    <div class="icon-circle"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3>Terverifikasi</h3>
                    <p>Tim kami sudah tes & wawancara Ibu Kos</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-circle"><i class="fa-solid fa-chart-line"></i></div>
                    <h3>Transparan</h3>
                    <p>Ada info kisaran harga, anti-tipu</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-circle"><i class="fa-solid fa-user-group"></i></div>
                    <h3>Pilihan</h3>
                    <p>Bukan cuma 1, ada beberapa opsi tukang</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-circle"><i class="fa-solid fa-location-dot"></i></div>
                    <h3>Hyperlocal</h3>
                    <p>Fokus di zona kosanmu</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section how-it-works">
        <div class="container">
            <h2 class="section-title reveal">Cara Kerja</h2>
            
            <div class="steps-container reveal">
                <div class="steps-line"></div>

                <div class="step-item">
                    <div class="step-icon blue-filled"><i class="fa-regular fa-credit-card"></i></div>
                    <h3>Daftar & Bayar</h3>
                    <p>1x untuk selamanya</p>
                </div>

                <div class="step-item">
                    <div class="step-icon blue-filled"><i class="fa-solid fa-map-location-dot"></i></div>
                    <h3>Pilih Zona Kosanmu</h3>
                    <p>UI atau Gunadarma</p>
                </div>

                <div class="step-item">
                    <div class="step-icon blue-filled"><i class="fa-solid fa-phone"></i></div>
                    <h3>Lihat & Hubungi</h3>
                    <p>Tukang Terverifikasi!</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section locations">
        <div class="container">
            <h2 class="section-title reveal">Saat Ini Tersedia di:</h2>
            <div class="grid-2 reveal">
                <div class="card loc-card active">
                    <div class="loc-icon-bg"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div class="loc-info">
                        <h3>Universitas Indonesia <span class="badge">Aktif</span></h3>
                        <p>Beji, Kukusan, Pondok Cina</p>
                    </div>
                </div>
                <div class="card loc-card inactive">
                    <div class="loc-icon-bg"><i class="fa-regular fa-clock"></i></div>
                    <div class="loc-info">
                        <h3>Universitas Gunadarma</h3>
                        <p>Segera Hadir!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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