```markdown
# BIAYA PASANG BILED SCOOPY

Aplikasi ini adalah sistem sederhana untuk mengelola biaya pemasangan berbagai item seperti sakelar, lampu, dan lainnya. Dibuat dengan PHP murni dan menggunakan database MySQL.

## Struktur Direktori
- config.php - File konfigurasi koneksi database.
- index.php - Antarmuka utama aplikasi untuk pengelolaan item.
- migrate.php - Skrip migrasi database untuk membuat database dan tabel jika belum ada.

## Persyaratan
- PHP 8.2 atau lebih baru
- MySQL/MariaDB
- Composer (opsional, jika Anda ingin menambahkan pustaka tambahan)
- Web server seperti Apache atau Nginx

## Instalasi

1. Clone Repository  
   Clone repository ini ke dalam folder lokal Anda:
   ```bash
   git clone https://github.com/FerdiNurrahman/BIAYA-PASANG.git
   cd biaya-pasang-biled-scoopy
   ```

2. Konfigurasi Database
   - Buka `config.php` dan sesuaikan parameter database Anda:
     ```php
     $host = 'localhost';
     $dbname = 'biaya_pasang';
     $username = 'root';
     $password = '';
     ```
   - Pastikan parameter di atas sesuai dengan koneksi database lokal Anda.

3. Migrasi Database
   - Jalankan skrip migrasi untuk membuat database dan tabel jika belum ada:
     ```bash
     php migrate.php
     ```
   - Skrip `migrate.php` akan membuat database `biaya_pasang` dan tabel `biaya_items`.

## Penggunaan

1. Menjalankan Aplikasi
   - Setelah migrasi berhasil, jalankan aplikasi dengan membuka `index.php` di web server Anda (misalnya, `http://localhost/biaya-pasang-biled-scoopy/index.php`).

2. Fitur Utama
   - Tambah Item: Masukkan nama item dan harga, lalu klik tombol tambah untuk menambahkan item baru.
   - Edit Item: Klik ikon edit di sebelah item yang ingin diubah, lalu simpan perubahan.
   - Hapus Item: Klik ikon hapus di sebelah item yang ingin dihapus, dan konfirmasi aksi.

3. Total Biaya: Total dari semua harga item akan muncul di bawah daftar item.

## Catatan Tambahan
- Jika Anda melakukan perubahan pada struktur tabel di masa mendatang, tambahkan query migrasi tambahan di `migrate.php`.
- Untuk notifikasi dan modals, aplikasi ini menggunakan SweetAlert2 dan Bootstrap 5. Pastikan koneksi internet untuk mengunduh pustaka ini secara otomatis.

