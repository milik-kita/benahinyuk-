window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active'); 
        }
    });
}, {
    threshold: 0.1 
});

const hiddenElements = document.querySelectorAll('.reveal');
hiddenElements.forEach((el) => observer.observe(el));


const inactiveCard = document.querySelector('.loc-card.inactive');

if (inactiveCard) {
    inactiveCard.addEventListener('click', function() {
        alert("Ops! Wilayah Universitas Gunadarma sedang dalam persiapan. Tunggu kabar baiknya ya!");
    });
}

const buttons = document.querySelectorAll('.btn, .nav-link');
buttons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        if(this.getAttribute('href') === '#') {
            e.preventDefault(); 
            if (!this.closest('.loc-card')) { 
                alert("Fitur ini akan segera aktif! Website ini masih dalam tahap demonstrasi.");
            }
        }
    });
});

const loginForm = document.getElementById('loginForm');

if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault(); 

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn = document.getElementById('loginBtn');
        const originalText = btn.innerText;

        if(email === "" || password === "") {
            alert("Harap isi email dan password!");
            return;
        }
        btn.innerText = "Memproses...";
        btn.style.opacity = "0.7";
        btn.disabled = true;
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.opacity = "1";
            btn.disabled = false;
            if(password.length < 6) {
                alert("Password terlalu pendek! (Minimal 6 karakter)");
            } else {
                alert("Login Berhasil! Selamat datang kembali.");
            }
        }, 1500);
    });
}

function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert("Nomor rekening berhasil disalin: " + text);
    }).catch(err => {
        console.error('Gagal menyalin: ', err);
    });
}


const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const uploadText = document.getElementById('uploadText');

if (uploadArea) {

    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            uploadText.innerHTML = `<strong>File Terpilih:</strong> ${fileName}`;
            uploadArea.style.borderColor = "#22c55e"; 
            uploadArea.style.backgroundColor = "#f0fdf4";
        }
    });
}

const registerForm = document.getElementById('registerForm');

if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if(fileInput.files.length === 0) {
            alert("Mohon upload bukti transfer terlebih dahulu!");
            return;
        }

        const btn = document.getElementById('regBtn');
        const originalText = btn.innerText;

        btn.innerText = "Mengirim Data...";
        btn.style.opacity = "0.7";
        btn.disabled = true;
        setTimeout(() => {
            alert("Pendaftaran Berhasil! Selamat datang di Dashboard Premium.");
            window.location.href = "dashboard.html";
            btn.style.opacity = "1";
            btn.disabled = false;
            registerForm.reset();
            uploadText.innerText = "Klik untuk upload atau drag & drop";
            uploadArea.style.borderColor = "#d1d5db";
            uploadArea.style.backgroundColor = "#fdfdfd";
        }, 2000);
    });
}

function hubungiWA(namaTukang) {
    alert("Membuka WhatsApp untuk menghubungi " + namaTukang + "...");
}

function hubungiTelp(namaTukang) {
    alert("Membuka menu telepon untuk menghubungi " + namaTukang + "...");
}