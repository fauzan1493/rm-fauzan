<?php
include 'koneksi.php';

// Ambil filter
$filter = $_GET['filter'] ?? 'semua';
$where = '';
$judul = 'Semua Transaksi';

if ($filter == 'hari') {
    $where = "WHERE DATE(tanggal) = CURDATE()";
    $judul = 'Transaksi Hari Ini';
} elseif ($filter == 'minggu') {
    $where = "WHERE YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)";
    $judul = 'Transaksi Minggu Ini';
} elseif ($filter == 'bulan') {
    $where = "WHERE YEAR(tanggal) = YEAR(CURDATE()) AND MONTH(tanggal) = MONTH(CURDATE())";
    $judul = 'Transaksi Bulan Ini';
} elseif ($filter == 'tahun') {
    $where = "WHERE YEAR(tanggal) = YEAR(CURDATE())";
    $judul = 'Transaksi Tahun Ini';
}

$transaksi = $koneksi->query("SELECT * FROM transaksi $where ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rekapan Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 w-64 h-screen bg-white shadow flex flex-col z-10">
        <div class="p-6 border-b">
            <span class="font-bold text-xl">FAUZAN <span class="text-blue-600">APK</span></span>
        </div>
        <nav class="flex-1 p-4 space-y-4">
            <a href="index.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="home"></i> Dashboard
            </a>
            <a href="kasir.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="dollar-sign"></i> Kasir
            </a>
            <a href="rekapan.php" class="flex items-center gap-3 text-blue-600 font-bold">
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
    <!-- Main Content -->
    <main class="flex-1 p-8 ml-64">
        <h1 class="text-2xl font-bold mb-4">Rekapan Transaksi</h1>
        <div class="mb-4 flex gap-2">
            <a href="?filter=semua" class="px-3 py-1 rounded <?= $filter=='semua'?'bg-blue-600 text-white':'bg-gray-200' ?>">Semua</a>
            <a href="?filter=hari" class="px-3 py-1 rounded <?= $filter=='hari'?'bg-blue-600 text-white':'bg-gray-200' ?>">Hari Ini</a>
            <a href="?filter=minggu" class="px-3 py-1 rounded <?= $filter=='minggu'?'bg-blue-600 text-white':'bg-gray-200' ?>">Minggu Ini</a>
            <a href="?filter=bulan" class="px-3 py-1 rounded <?= $filter=='bulan'?'bg-blue-600 text-white':'bg-gray-200' ?>">Bulan Ini</a>
            <a href="?filter=tahun" class="px-3 py-1 rounded <?= $filter=='tahun'?'bg-blue-600 text-white':'bg-gray-200' ?>">Tahun Ini</a>
        </div>
        <h2 class="text-xl font-semibold mb-2"><?= $judul ?></h2>
        <table class="border w-full bg-white rounded shadow mb-4">
            <tr class="bg-gray-200">
                <th class="px-2 py-1">ID</th>
                <th class="px-2 py-1">Tanggal</th>
                <th class="px-2 py-1">Nama Pembeli</th>
                <th class="px-2 py-1">Total</th>
                <th class="px-2 py-1">Detail</th>
            </tr>
            <?php while($t = $transaksi->fetch_assoc()): ?>
            <tr>
                <td class="px-2 py-1"><?= $t['id'] ?></td>
                <td class="px-2 py-1"><?= $t['tanggal'] ?></td>
                <td class="px-2 py-1"><?= htmlspecialchars($t['nama_pembeli'] ?? '-') ?></td>
                <td class="px-2 py-1">Rp <?= number_format($t['total']) ?></td>
                <td class="px-2 py-1">
                    <a href="rekapan.php?filter=<?= $filter ?>&detail=<?= $t['id'] ?>" class="text-blue-600">Lihat</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php
        if (isset($_GET['detail'])):
            $id = intval($_GET['detail']);
            $detail = $koneksi->query("SELECT d.*, b.nama_barang FROM detail_transaksi d JOIN barang b ON d.barang_id=b.id WHERE d.transaksi_id=$id");
        ?>
        <h2 class="text-xl font-semibold mb-2">Detail Transaksi #<?= $id ?></h2>
        <table class="border w-1/2 mb-4 bg-white rounded shadow">
            <tr class="bg-gray-200">
                <th class="px-2 py-1">Barang</th>
                <th class="px-2 py-1">Jumlah</th>
                <th class="px-2 py-1">Subtotal</th>
            </tr>
            <?php while($d = $detail->fetch_assoc()): ?>
            <tr>
                <td class="px-2 py-1"><?= $d['nama_barang'] ?></td>
                <td class="px-2 py-1"><?= $d['jumlah'] ?></td>
                <td class="px-2 py-1">Rp <?= number_format($d['subtotal']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="rekapan.php?filter=<?= $filter ?>" class="text-blue-600">Kembali</a>
        <?php endif; ?>
        <a href="kasir.php" class="text-blue-600 mt-4 inline-block">Kembali ke Kasir</a>
    </main>
    <script>
        feather.replace()
    </script>
</body>
</html>