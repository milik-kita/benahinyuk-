<?php
session_start();
include 'koneksi.php';

$password_rahasia = "kuynihanebtim"; 

if (isset($_POST['login_admin'])) {
    if ($_POST['password'] == $password_rahasia) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Password salah!";
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged_in']);
    header("Location: admin.php");
    exit;
}

if (!isset($_SESSION['admin_logged_in'])) {
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login Admin</title>
        <link rel="stylesheet" href="style.css">
        <style>
            body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; }
            .login-box { background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
            input { padding: 10px; margin: 10px 0; width: 100%; box-sizing: border-box; }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h3>🔒 Area Terlarang</h3>
            <p>Masukkan Password Admin</p>
            <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
            <form method="POST">
                <input type="password" name="password" placeholder="Password..." required>
                <button type="submit" name="login_admin" class="btn btn-orange">Buka Pintu</button>
            </form>
        </div>
    </body>
    </html>
<?php
    exit; 
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    
    $status_baru = ($action == 'aktifkan') ? 1 : 0;

    $update = mysqli_query($conn, "UPDATE users SET status = $status_baru WHERE id = $id");
    
if ($update) {
    header("Location: admin.php?pesan=sukses");
    exit;
    } else {
        echo "<script>alert('Gagal mengubah database.');</script>";
    }
}

$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BenahinYuk</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-container { max-width: 1000px; margin: 50px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header-admin { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        th { background-color: #f9fafb; font-weight: 700; color: #374151; }
        tr:hover { background-color: #f9fafb; }

        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .pending { background: #fff7ed; color: #c2410c; }
        .active { background: #dcfce7; color: #15803d; }

        .btn-sm { padding: 5px 10px; font-size: 0.8rem; border-radius: 4px; text-decoration: none; color: white; margin-right: 5px; }
        .btn-green { background-color: #22c55e; }
        .btn-red { background-color: #ef4444; }
        .btn-view { background-color: #3b82f6; }
        
        .thumb-img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
    </style>
</head>
<body>

    <div class="admin-container">
        <div class="header-admin">
            <h2>🛠️ Admin Panel BenahinYuk</h2>
            <div>
                <a href="index.php" class="btn-sm btn-view" target="_blank">Lihat Web</a>
                <a href="admin.php?logout=1" class="btn-sm btn-red">Logout</a>
            </div>
        </div>

        <p>Total User Terdaftar: <strong><?= mysqli_num_rows($query) ?></strong></p>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama & Email</th>
                        <th>WhatsApp</th>
                        <th>Bukti Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td>#<?= $row['id'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['nama_lengkap']) ?></strong><br>
                            <span style="color:#666; font-size:0.8em;"><?= htmlspecialchars($row['email']) ?></span>
                        </td>
                        <td>
                            <a href="https://wa.me/<?= preg_replace('/^0/', '62', $row['whatsapp']) ?>" target="_blank" style="color:#25D366; text-decoration:none; font-weight:600;">
                                <i class="fa-brands fa-whatsapp"></i> Chat
                            </a>
                        </td>
                        <td>
                            <?php if($row['bukti_bayar']): ?>
                                <a href="uploads/<?= $row['bukti_bayar'] ?>" target="_blank">
                                    <img src="uploads/<?= $row['bukti_bayar'] ?>" class="thumb-img" alt="Bukti">
                                </a>
                            <?php else: ?>
                                <span style="color:red; font-size:0.8em;">Belum Upload</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['status'] == 1): ?>
                                <span class="status-badge active">✅ Aktif</span>
                            <?php else: ?>
                                <span class="status-badge pending">⏳ Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['status'] == 0): ?>
<button type="button" class="btn-sm btn-green" style="border:none; cursor:pointer;" 
    onclick="konfirmasiAksi('admin.php?id=<?= $row['id'] ?>&action=aktifkan', 'Yakin ingin mengaktifkan member <?= $row['nama_lengkap'] ?>?', 'aktifkan')">
    ✔ Aktifkan
</button>
                            <?php else: ?>
<button type="button" class="btn-sm btn-red" style="border:none; cursor:pointer;" 
    onclick="konfirmasiAksi('admin.php?id=<?= $row['id'] ?>&action=matikan', 'Yakin ingin menonaktifkan member <?= $row['nama_lengkap'] ?>?', 'matikan')">
    ✖ Matikan
</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<div id="adminModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <h3>Konfirmasi Admin</h3>
            <p id="modalText">Apakah Anda yakin ingin melakukan tindakan ini?</p>
            
            <div class="modal-buttons">
                <button onclick="tutupModal()" class="btn-cancel">Batal</button>
                <a id="btnConfirm" href="#" class="btn-confirm">Ya, Lakukan</a>
            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); z-index: 9999;
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; animation: fadeIn 0.2s; }
        
        .modal-box {
            background: white; padding: 30px; border-radius: 12px;
            width: 90%; max-width: 400px; text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .modal-icon {
            font-size: 3rem; color: #3b82f6; margin-bottom: 15px;
        }
        
        .modal-buttons { display: flex; gap: 10px; margin-top: 25px; }
        
        .btn-confirm { 
            background: #3b82f6; color: white; padding: 10px 20px; 
            border-radius: 6px; text-decoration: none; flex: 1; font-weight: bold; 
            display: flex; align-items: center; justify-content: center;
        }
        .btn-cancel { 
            background: white; border: 1px solid #ddd; color: #555; 
            padding: 10px 20px; border-radius: 6px; cursor: pointer; flex: 1; 
        }

        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    </style>

    <script>
        function konfirmasiAksi(url, pesan, tipe) {
            document.getElementById('modalText').innerText = pesan;
            
            document.getElementById('btnConfirm').href = url;
            
            let btn = document.getElementById('btnConfirm');
            let icon = document.querySelector('.modal-icon');
            
            if(tipe == 'aktifkan') {
                btn.style.backgroundColor = '#22c55e'; 
                icon.style.color = '#22c55e';
            } else {
                btn.style.backgroundColor = '#ef4444'; 
                icon.style.color = '#ef4444';
            }

            document.getElementById('adminModal').classList.add('active');
        }

        function tutupModal() {
            document.getElementById('adminModal').classList.remove('active');
        }
        
        window.onclick = function(e) {
            if (e.target == document.getElementById('adminModal')) tutupModal();
        }        
        const urlParams = new URLSearchParams(window.location.search);
        const pesan = urlParams.get('pesan');

        if (pesan === 'sukses') {
            document.getElementById('successModal').classList.add('active');
        }

        function tutupSukses() {
            document.getElementById('successModal').classList.remove('active');
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>

    <div id="successModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="color: #22c55e; background-color: #dcfce7;">
                <i class="fa-solid fa-check"></i>
            </div>
            <h3>Berhasil!</h3>
            <p>Status member berhasil diperbarui.</p>
            
            <div class="modal-buttons">
                <button onclick="tutupSukses()" class="btn-confirm" style="background-color: #22c55e;">OK, Mantap</button>
            </div>
        </div>
    </div>

</body>
</html>