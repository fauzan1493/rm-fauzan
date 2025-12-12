# Aplikasi Kasir FAUZAN

Aplikasi kasir ini dirancang untuk memudahkan pengelolaan transaksi penjualan barang. Proyek ini terdiri dari beberapa file yang saling terhubung untuk memberikan fungsionalitas yang lengkap.

## Struktur Proyek

```
apkkasir
├── config
│   └── database.php        # Konfigurasi koneksi database
├── public
│   ├── index.php          # Titik masuk aplikasi
│   └── assets
│       └── style.css      # Gaya CSS untuk aplikasi
├── src
│   ├── kasir.php          # Logika untuk halaman kasir
│   ├── barang.php         # Logika untuk mengelola data barang
│   ├── rekapan.php        # Logika untuk menampilkan rekapan transaksi
│   ├── tambah_barang.php   # Logika untuk menambahkan barang baru
│   └── cetak_nota.php     # Logika untuk mencetak nota transaksi
├── templates
│   ├── header.php         # Bagian header untuk berbagai halaman
│   └── footer.php         # Bagian footer untuk berbagai halaman
└── README.md              # Dokumentasi proyek
```

## Instalasi

1. **Clone Repository**: 
   ```bash
   git clone <repository-url>
   ```

2. **Masuk ke Direktori Proyek**:
   ```bash
   cd apkkasir
   ```

3. **Konfigurasi Database**:
   - Buka file `config/database.php` dan sesuaikan pengaturan koneksi database sesuai dengan lingkungan Anda.

4. **Jalankan Aplikasi**:
   - Akses aplikasi melalui browser dengan membuka `http://localhost/apkkasir/public/index.php`.

## Fitur

- **Manajemen Barang**: Tambah, lihat, dan kelola barang yang tersedia.
- **Transaksi Kasir**: Proses transaksi penjualan dan cetak nota.
- **Rekapan Transaksi**: Lihat rekapan hasil transaksi yang telah dilakukan.

## Penggunaan

- **Halaman Tambah Barang**: Akses halaman ini untuk menambahkan barang baru ke dalam database.
- **Halaman Kasir**: Gunakan halaman ini untuk melakukan transaksi penjualan dan mencetak nota.
- **Halaman Rekapan**: Lihat semua transaksi yang telah dilakukan dalam bentuk rekapan.

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan buat pull request atau buka isu untuk diskusi lebih lanjut.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).