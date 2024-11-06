<?php
$host = 'localhost';
$dbname = 'biaya_pasang';
$username = 'root';
$password = '';

try {
    // Sambungkan ke MySQL tanpa memilih database terlebih dahulu
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Periksa apakah database sudah ada
    $stmt = $conn->query("SHOW DATABASES LIKE '$dbname'");
    $databaseExists = $stmt->rowCount() > 0;

    // Jika database tidak ada, buat database dan tabel
    if (!$databaseExists) {
        echo "Database belum ada. Membuat database dan tabel...\n";
        
        // Buat database
        $conn->exec("CREATE DATABASE `$dbname`");
        $conn->exec("USE `$dbname`");

        // Buat tabel `biaya_items`
        $createTableSQL = "
            CREATE TABLE `biaya_items` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama_item` varchar(255) NOT NULL,
                `harga` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        $conn->exec($createTableSQL);

        echo "Database dan tabel berhasil dibuat.\n";
    } else {
        // Jika database sudah ada, jalankan query migrasi (jika diperlukan)
        $conn->exec("USE `$dbname`");

        // echo "Database sudah ada. Memeriksa pembaruan struktur tabel...\n";
        
        // Contoh query migrasi, misalnya menambahkan kolom baru jika diperlukan
        // $conn->exec("ALTER TABLE `biaya_items` ADD COLUMN `deskripsi` TEXT NULL AFTER `harga`");

        // echo "Struktur database telah diperbarui.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
