<?php
session_start();
include 'koneksi.php';

// Proses tambah ke nota
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $barang = $koneksi->query("SELECT * FROM barang WHERE id=$id_barang")->fetch_assoc();
    $nota = $_SESSION['nota'] ?? [];
    $nota[] = [
        'id_barang' => $id_barang,
        'nama_barang' => $barang['nama_barang'],
        'harga_jual' => $barang['harga_jual'],
        'jumlah' => $jumlah,
        'subtotal' => $barang['harga_jual'] * $jumlah
    ];
    $_SESSION['nota'] = $nota;
    header("Location: kasir.php");
    exit;
}

// Proses simpan transaksi
if (isset($_POST['selesai'])) {
    $nota = $_SESSION['nota'] ?? [];
    $nama_pembeli = $_POST['nama_pembeli'] ?? '';
    $stok_kurang = false;
    $barang_kurang = [];

    // Cek stok cukup
    foreach ($nota as $item) {
        $idb = $item['id_barang'];
        $jml = $item['jumlah'];
        $stok = $koneksi->query("SELECT jumlah FROM barang WHERE id=$idb")->fetch_assoc()['jumlah'];
        if ($jml > $stok) {
            $stok_kurang = true;
            $barang_kurang[] = $item['nama_barang'];
        }
    }

    if ($stok_kurang) {
        $pesan = "Stok tidak cukup untuk barang: " . implode(', ', $barang_kurang) . ". Transaksi dibatalkan!";
    } elseif ($nota && $nama_pembeli != '') {
        $total = array_sum(array_column($nota, 'subtotal'));
        $koneksi->query("INSERT INTO transaksi (nama_pembeli, total) VALUES ('$nama_pembeli', $total)");
        $transaksi_id = $koneksi->insert_id;
        foreach ($nota as $item) {
            $idb = $item['id_barang'];
            $jml = $item['jumlah'];
            $sub = $item['subtotal'];
            $koneksi->query("INSERT INTO detail_transaksi (transaksi_id, barang_id, jumlah, subtotal) VALUES ($transaksi_id, $idb, $jml, $sub)");
            // Update stok barang
            $koneksi->query("UPDATE barang SET jumlah = jumlah - $jml WHERE id = $idb");
        }
        unset($_SESSION['nota']);
        $pesan = "Transaksi berhasil disimpan!";
    } else {
        $pesan = "Nama pembeli harus diisi!";
    }
}

// Ambil data barang
$barang = $koneksi->query("SELECT * FROM barang");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
    // Script untuk menampilkan harga otomatis
    document.addEventListener('DOMContentLoaded', function() {
        const barangData = {};
        <?php
        $barang->data_seek(0);
        while($b = $barang->fetch_assoc()) {
            echo "barangData[{$b['id']}] = {$b['harga_jual']};\n";
        }
        $barang->data_seek(0);
        ?>
        const selectBarang = document.getElementById('id_barang');
        const hargaInput = document.getElementById('harga_jual');
        if(selectBarang && hargaInput) {
            selectBarang.addEventListener('change', function() {
                const harga = barangData[this.value] || '';
                hargaInput.value = harga ? 'Rp ' + harga.toLocaleString() : '';
            });
        }
    });
    </script>
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
            <a href="kasir.php" class="flex items-center gap-3 text-blue-600 font-bold">
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
    <!-- Main Content -->
    <main class="flex-1 p-8 ml-64">
        <h1 class="text-2xl font-bold mb-4">Menu Kasir</h1>
        <?php if (!empty($pesan)) echo "<div class='mb-4 text-".(strpos($pesan, 'berhasil')!==false?'green':'red')."-600'>$pesan</div>"; ?>
        <!-- Form tambah barang ke nota -->
        <form method="post" class="mb-6 bg-white p-4 rounded shadow w-full max-w-lg flex gap-4 items-end">
            <div class="flex-1">
                <label class="block mb-1 font-semibold">Pilih Barang</label>
                <select name="id_barang" id="id_barang" required class="border px-2 py-1 w-full rounded">
                    <option value="">-- Pilih Barang --</option>
                    <?php $barang->data_seek(0); while($b = $barang->fetch_assoc()): ?>
                        <option value="<?= $b['id'] ?>"><?= $b['nama_barang'] ?> (<?= $b['kode_barang'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Harga</label>
                <input type="text" id="harga_jual" class="border px-2 py-1 w-32 rounded bg-gray-100" readonly>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Jumlah</label>
                <input type="number" name="jumlah" min="1" value="1" required class="border px-2 py-1 w-20 rounded">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
        </form>
        <!-- Nota Sementara -->
        <h2 class="text-xl font-semibold mb-2">Nota Sementara</h2>
        <table class="border w-full bg-white rounded shadow mb-4">
            <tr class="bg-gray-200">
                <th class="px-2 py-1">No</th>
                <th class="px-2 py-1">Nama Barang</th>
                <th class="px-2 py-1">Harga</th>
                <th class="px-2 py-1">Jumlah</th>
                <th class="px-2 py-1">Subtotal</th>
            </tr>
            <?php
            $nota = $_SESSION['nota'] ?? [];
            $total = 0; $no = 1;
            foreach ($nota as $item):
                $total += $item['subtotal'];
            ?>
            <tr>
                <td class="px-2 py-1"><?= $no++ ?></td>
                <td class="px-2 py-1"><?= $item['nama_barang'] ?></td>
                <td class="px-2 py-1">Rp <?= number_format($item['harga_jual']) ?></td>
                <td class="px-2 py-1"><?= $item['jumlah'] ?></td>
                <td class="px-2 py-1">Rp <?= number_format($item['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="font-bold text-right px-2 py-1">Total</td>
                <td class="font-bold px-2 py-1">Rp <?= number_format($total) ?></td>
            </tr>
        </table>
        <!-- Form nama pembeli dan simpan transaksi -->
        <form method="post" class="mb-4 flex gap-4 items-end">
            <div>
                <label class="block mb-1 font-semibold">Nama Pembeli</label>
                <input type="text" name="nama_pembeli" required class="border px-2 py-1 rounded">
            </div>
            <button type="submit" name="selesai" class="bg-green-600 text-white px-4 py-2 rounded">Selesai & Simpan</button>
        </form>
        <a href="rekapan.php" class="text-blue-600 mt-4 inline-block">Lihat Rekapan</a>
    </main>
    <script>
        feather.replace()
    </script>
</body>
</html>