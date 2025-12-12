<?php
session_start();
include 'koneksi.php';

// Inisialisasi pesan
$login_msg = $reg_msg = "";

// Registrasi
if (isset($_POST['register'])) {
    $username = trim($_POST['reg_username']);
    $nama = trim($_POST['reg_nama']);
    $password = $_POST['reg_password'];
    $level = $_POST['reg_level'];
    if ($username == "" || $nama == "" || $password == "" || $level == "") {
        $reg_msg = "Semua field harus diisi!";
    } else {
        $cek = $koneksi->query("SELECT * FROM users WHERE username='$username'");
        if ($cek->num_rows > 0) {
            $reg_msg = "Username sudah terdaftar!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $koneksi->query("INSERT INTO users (username, password, nama, level) VALUES ('$username', '$hash', '$nama', '$level')");
            $reg_msg = "Registrasi berhasil! Silakan login.";
        }
    }
}

// Login
if (isset($_POST['login'])) {
    $username = trim($_POST['login_username']);
    $password = $_POST['login_password'];
    if ($username == "" || $password == "") {
        $login_msg = "Username dan password harus diisi!";
    } else {
        $user = $koneksi->query("SELECT * FROM users WHERE username='$username'")->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'nama' => $user['nama'],
                'level' => $user['level']
            ];
            header("Location: kasir.php");
            exit;
        } else {
            $login_msg = "Username atau password salah!";
        }
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login dan resgistrasi.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login & Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab-btn.active {
            @apply bg-blue-600 text-white;
        }
        .tab-btn:not(.active) {
            @apply bg-gray-200 text-gray-700;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <div class="flex mb-6">
            <button id="btn-login" class="tab-btn flex-1 py-2 rounded-l-lg font-semibold active">Login</button>
            <button id="btn-register" class="tab-btn flex-1 py-2 rounded-r-lg font-semibold">Registrasi</button>
        </div>
        <!-- Login Form -->
        <form id="form-login" method="post" class="<?= !empty($reg_msg) ? 'hidden' : '' ?>">
            <?php if (!empty($login_msg)) echo "<div class='mb-3 text-red-600 text-center'>$login_msg</div>"; ?>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Username</label>
                <input type="text" name="login_username" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Password</label>
                <input type="password" name="login_password" required class="border px-2 py-1 w-full rounded">
            </div>
            <button type="submit" name="login" class="bg-blue-600 text-white px-4 py-2 rounded w-full font-semibold">Login</button>
        </form>
        <!-- Register Form -->
        <form id="form-register" method="post" class="<?= empty($reg_msg) ? 'hidden' : '' ?>">
            <?php if (!empty($reg_msg)) echo "<div class='mb-3 text-".(strpos($reg_msg,'berhasil')!==false?'green':'red')."-600 text-center'>$reg_msg</div>"; ?>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Nama</label>
                <input type="text" name="reg_nama" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Username</label>
                <input type="text" name="reg_username" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Password</label>
                <input type="password" name="reg_password" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Level</label>
                <select name="reg_level" required class="border px-2 py-1 w-full rounded">
                    <option value="">-- Pilih Level --</option>
                    <option value="karyawan">Karyawan</option>
                    <option value="pemilik">Pemilik</option>
                </select>
            </div>
            <button type="submit" name="register" class="bg-green-600 text-white px-4 py-2 rounded w-full font-semibold">Registrasi</button>
        </form>
        <div class="mt-6 text-center text-gray-500 text-sm">
            &copy; <?= date('Y') ?> APK Kasir - FAUZAN
        </div>
    </div>
    <script>
        // Tab switcher
        const btnLogin = document.getElementById('btn-login');
        const btnRegister = document.getElementById('btn-register');
        const formLogin = document.getElementById('form-login');
        const formRegister = document.getElementById('form-register');

        btnLogin.onclick = function() {
            btnLogin.classList.add('active');
            btnRegister.classList.remove('active');
            formLogin.classList.remove('hidden');
            formRegister.classList.add('hidden');
        };
        btnRegister.onclick = function() {
            btnRegister.classList.add('active');
            btnLogin.classList.remove('active');
            formRegister.classList.remove('hidden');
            formLogin.classList.add('hidden');
        };
        // Auto switch to register if ada pesan reg_msg
        <?php if (!empty($reg_msg)) : ?>
        btnRegister.classList.add('active');
        btnLogin.classList.remove('active');
        formRegister.classList.remove('hidden');
        formLogin.classList.add('hidden');
        <?php endif; ?>
    </script>
</body>
</html>