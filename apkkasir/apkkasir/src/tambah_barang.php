<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Tambah Barang - FAUZAN APK</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="../public/assets/style.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="flex items-center gap-2 px-6 py-5 border-b border-gray-200">
                <h1 class="text-lg font-semibold text-gray-800">FAUZAN <span class="text-blue-600">APK</span></h1>
            </div>
            <nav class="flex flex-col mt-6 space-y-1 text-sm">
                <a class="flex items-center gap-3 px-6 py-3 text-gray-400 hover:text-gray-700" href="kasir.php">
                    <i class="fas fa-dollar-sign text-lg"></i>
                    <span>Kasir</span>
                </a>
                <a class="flex items-center gap-3 px-6 py-3 text-gray-400 hover:text-gray-700" href="rekapan.php">
                    <i class="fas fa-users text-lg"></i>
                    <span>Rekapan</span>
                </a>
                <a class="flex items-center gap-3 px-6 py-3 text-gray-400 hover:text-gray-700" href="barang.php">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Barang</span>
                </a>
                <a class="flex items-center gap-3 px-6 py-3 text-gray-400 hover:text-gray-700" href="pengguna.php">
                    <i class="fas fa-user-circle text-lg"></i>
                    <span>Pengguna</span>
                </a>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Barang</h2>
            <form action="tambah_barang.php" method="POST" class="bg-white p-4 rounded shadow">
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"/>
                </div>
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="harga" name="harga" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"/>
                </div>
                <div class="mb-4">
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" id="stok" name="stok" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"/>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Tambah Barang</button>
            </form>
        </main>
    </div>
</body>
</html>