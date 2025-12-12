<?php
include 'koneksi.php';

// Total penjualan hari ini
$penjualan = $koneksi->query("SELECT SUM(total) as total FROM transaksi WHERE DATE(tanggal) = CURDATE()")->fetch_assoc();
$total_hari_ini = $penjualan['total'] ?? 0;

// Jumlah produk
$jml_produk = $koneksi->query("SELECT COUNT(*) as jml FROM barang")->fetch_assoc()['jml'];

// Semua produk (tanpa LIMIT)
$produk = $koneksi->query("SELECT * FROM barang ORDER BY tanggal_masuk DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 w-64 h-screen bg-white shadow flex flex-col z-10">
        <div class="p-6 border-b">
            <span class="font-bold text-xl">FAUZAN <span class="text-blue-600">APK</span></span>
        </div>
        <nav class="flex-1 p-4 space-y-4">
            <a href="Dashboard.php" class="flex items-center gap-3 text-blue-600 font-bold">
                <i data-feather="home"></i> Dashboard
            </a>
            <a href="kasir.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="dollar-sign"></i> Kasir
            </a>
            <a href="rekapan.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="users"></i> Rekapan
            </a>
            <a href="barang.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="shopping-cart"></i> Barang
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="user"></i> Pengguna
            </a>
        </nav>
    </aside>
    <!-- Fixed Header -->
    <header class="fixed top-0 left-64 right-0 bg-white z-20 shadow px-8 py-4 flex flex-col">
        <h1 class="text-3xl font-extrabold tracking-wide mb-1 text-blue-700">DASHBOARD KASIR</h1>
        <p class="text-base text-gray-600">Selamat datang di aplikasi kasir FAUZAN APK</p>
    </header>
    <!-- Main Content -->
    <main class="flex-1 p-8 ml-64 pt-28">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Penjualan Hari Ini -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                <div class="bg-blue-100 text-blue-700 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 0V4m0 16v-4m8-4h-4m-8 0H4"/>
                    </svg>
                </div>
                <div>
                    <div class="text-gray-500 font-semibold">Penjualan Hari Ini</div>
                    <div class="text-2xl font-bold text-blue-700">Rp <?= number_format($total_hari_ini) ?></div>
                </div>
            </div>
            <!-- Info Produk -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                <div class="bg-green-100 text-green-700 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10v10a1 1 0 001 1h14a1 1 0 001-1V10M4 10l8 4 8-4"/>
                    </svg>
                </div>
                <div>
                    <div class="text-gray-500 font-semibold">Jumlah Produk</div>
                    <div class="text-2xl font-bold text-green-700"><?= $jml_produk ?></div>
                </div>
            </div>
        </div>
        <!-- Semua Produk -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-blue-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4"/>
                </svg>
                Semua Produk
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php while($b = $produk->fetch_assoc()): ?>
                <div class="bg-gray-50 rounded-lg shadow p-4 flex flex-col items-center">
                    <?php if (!empty($b['gambar']) && file_exists(__DIR__.'/uploads/'.$b['gambar'])): ?>
                        <img src="uploads/<?= $b['gambar'] ?>" alt="<?= $b['nama_barang'] ?>" class="w-24 h-24 object-cover rounded mb-2 border">
                    <?php else: ?>
                        <div class="w-24 h-24 flex items-center justify-center bg-gray-200 rounded mb-2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10v10a1 1 0 001 1h14a1 1 0 001-1V10M4 10l8 4 8-4"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="font-bold text-lg text-center"><?= $b['nama_barang'] ?></div>
                    <div class="text-gray-500 text-sm mb-1"><?= $b['kode_barang'] ?></div>
                    <div class="text-blue-700 font-semibold">Rp <?= number_format($b['harga_jual']) ?></div>
                    <div class="text-xs text-gray-400 mt-1">Stok: <?= $b['jumlah'] ?></div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <script>
        feather.replace()
    </script>
</body>
</html>