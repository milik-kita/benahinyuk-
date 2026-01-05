<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Benahin Yuk</title>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="nav-link" style="font-weight: bold; color: #1a73e8;">Dashboard</a>
                    <a href="logout.php" class="btn btn-orange" style="background-color: #ef4444;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Login</a>
                    <a href="register.php" class="btn btn-orange">Daftar Sekarang (Rp 15.000)</a>
                    <!-- <a href="https://forms.gle/c4oXptnLeZgzfuVr9" target="_blank" class="btn btn-orange">Daftar Sekarang</a> -->

                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="section about-page">
        <div class="container">
            
            <div>
                <h2 class="section-title">Siapa di Balik benahinyuk?</h2>
                <div class="story-card">
                    <p>Kami adalah mahasiswa yang juga anak kos, sama seperti kamu. Kami pernah merasakan frustrasi saat kipas rusak di tengah panas terik, setrika mati menjelang presentasi penting, atau harus keluar uang lebih banyak karena tidak tahu tukang mana yang jujur.</p>
                    <br>
                    <p>Dari pengalaman itulah, kami memutuskan untuk membuat <span class="highlight-blue">benahinyuk</span> - sebuah platform yang membantu anak kos perantau mendapatkan akses ke tukang servis yang jujur, terverifikasi, dan terpercaya di area kosan mereka.</p>
                    <br>
                    <p>Misi kami sederhana: memberikan ketenangan pikiran untuk anak kos yang sedang fokus belajar, dengan memastikan masalah rumah tangga kecil bisa diselesaikan dengan cepat dan tanpa drama.</p>
                </div>
            </div>

            <div class="mt-80">
                <h2 class="section-title">Metodologi Verifikasi Kami</h2>
                <div class="grid-3">
                    <div class="card methodology-card">
                        <div class="icon-circle blue-filled-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3>Discovery</h3>
                        <p>Kami melakukan riset mendalam dengan mewawancarai Ibu Kos dan mahasiswa di berbagai area kosan untuk mendapatkan rekomendasi tukang yang terpercaya.</p>
                    </div>

                    <div class="card methodology-card">
                        <div class="icon-circle blue-filled-icon">
                            <i class="fa-regular fa-circle-check"></i>
                        </div>
                        <h3>Screening</h3>
                        <p>Setiap tukang yang direkomendasikan kami verifikasi langsung - dari track record, transparansi harga, hingga cara kerja mereka.</p>
                    </div>

                    <div class="card methodology-card">
                        <div class="icon-circle blue-filled-icon">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <h3>Verifikasi & Tes Servis</h3>
                        <p>Tim kami melakukan uji coba langsung layanan servis untuk memastikan kualitas dan kejujuran dalam penawaran harga.</p>
                    </div>
                </div>
            </div>

            <div class="mt-80">
                <div class="story-card text-center">
                    <h3>Komitmen Kami</h3>
                    <p class="mt-20">Setiap tukang dalam database kami telah melalui proses verifikasi ketat. Kami tidak hanya mengumpulkan nama dan nomor telepon - kami memastikan mereka layak dipercaya untuk membantu sesama anak kos.</p>
                    
                    <div class="verified-badge">
                        <i class="fa-solid fa-circle-check"></i> 100% Terverifikasi & Terpercaya
                    </div>
                </div>
            </div>

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
                    <li><a href="tentang-kami.php" style="color: #1a73e8; font-weight: bold;">Tentang Kami</a></li>
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