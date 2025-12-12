<?php
include 'koneksi.php';

// Proses tambah barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_barang'];
    $kode = $_POST['kode_barang'];
    $harga = $_POST['harga_jual'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal_masuk'];

    // Proses upload gambar
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_file = uniqid('barang_').'.'.$ext;
        $upload_path = __DIR__ . '/uploads/' . $nama_file;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
            $gambar = $nama_file;
        }
    }

    $koneksi->query("INSERT INTO barang (nama_barang, kode_barang, harga_jual, jumlah, tanggal_masuk, gambar) VALUES ('$nama', '$kode', '$harga', '$jumlah', '$tanggal', ".($gambar?"'$gambar'":"NULL").")");
    header("Location: barang.php");
    exit;
}

// Ambil data barang
$barang = $koneksi->query("SELECT * FROM barang ORDER BY tanggal_masuk DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
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
            <a href="Dashboard.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="home"></i> Dashboard
            </a>
            <a href="kasir.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="dollar-sign"></i> Kasir
            </a>
            <a href="rekapan.php" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="users"></i> Rekapan
            </a>
            <a href="barang.php" class="flex items-center gap-3 text-blue-600 font-bold">
                <i data-feather="shopping-cart"></i> Barang
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-600 hover:text-blue-600">
                <i data-feather="user"></i> Pengguna
            </a>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8 ml-64">
        <h1 class="text-2xl font-bold mb-4">Data Barang</h1>
        <form method="post" enctype="multipart/form-data" class="mb-6 bg-white p-4 rounded shadow w-full max-w-lg">
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Nama Barang</label>
                <input type="text" name="nama_barang" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Kode Barang</label>
                <input type="text" name="kode_barang" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Harga Jual</label>
                <input type="number" name="harga_jual" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Jumlah Barang</label>
                <input type="number" name="jumlah" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" required class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Foto Barang</label>
                <input type="file" name="gambar" accept="image/*" class="border px-2 py-1 w-full rounded">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Barang</button>
        </form>
        <h2 class="text-xl font-semibold mb-2">Daftar Barang</h2>
        <table class="border w-full bg-white rounded shadow">
            <tr class="bg-gray-200">
                <th class="px-2 py-1">No</th>
                <th class="px-2 py-1">Foto</th>
                <th class="px-2 py-1">Nama Barang</th>
                <th class="px-2 py-1">Kode Barang</th>
                <th class="px-2 py-1">Harga Jual</th>
                <th class="px-2 py-1">Jumlah</th>
                <th class="px-2 py-1">Tanggal Masuk</th>
            </tr>
            <?php $no=1; while($b = $barang->fetch_assoc()): ?>
            <tr>
                <td class="px-2 py-1"><?= $no++ ?></td>
                <td class="px-2 py-1">
                    <?php if (!empty($b['gambar']) && file_exists(__DIR__.'/uploads/'.$b['gambar'])): ?>
                        <img src="uploads/<?= $b['gambar'] ?>" alt="<?= $b['nama_barang'] ?>" class="w-12 h-12 object-cover rounded border">
                    <?php else: ?>
                        <span class="text-gray-400">-</span>
                    <?php endif; ?>
                </td>
                <td class="px-2 py-1"><?= $b['nama_barang'] ?></td>
                <td class="px-2 py-1"><?= $b['kode_barang'] ?></td>
                <td class="px-2 py-1">Rp <?= number_format($b['harga_jual']) ?></td>
                <td class="px-2 py-1"><?= $b['jumlah'] ?></td>
                <td class="px-2 py-1"><?= $b['tanggal_masuk'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
    <script>
        feather.replace()
    </script>
</body>
</html>