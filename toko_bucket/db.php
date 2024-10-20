<?php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "jual_bucket"; 

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Memeriksa koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Membuat tabel tb_categori jika belum ada
$createTableCategori = "
CREATE TABLE IF NOT EXISTS tb_categori (
    categori_id INT AUTO_INCREMENT PRIMARY KEY,
    categori_name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($conn, $createTableCategori)) {
    echo "Error creating table tb_categori: " . mysqli_error($conn);
}

// Membuat tabel tb_pelanggan jika belum ada
$createTablePelanggan = "
CREATE TABLE IF NOT EXISTS tb_pelanggan (
    pelanggan_id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_name VARCHAR(100) NOT NULL,
    pelanggan_email VARCHAR(100) NOT NULL,
    pelanggan_phone VARCHAR(15) NOT NULL,
    alamat TEXT NOT NULL,
    tanggal_daftar DATE NOT NULL DEFAULT CURRENT_DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($conn, $createTablePelanggan)) {
    echo "Error creating table tb_pelanggan: " . mysqli_error($conn);
}

// Membuat tabel tb_order jika belum ada
$createTableOrder = "
CREATE TABLE IF NOT EXISTS tb_order (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_name VARCHAR(100) NOT NULL,
    produk_name VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    total_harga DECIMAL(10, 2) NOT NULL,
    tanggal_order DATE NOT NULL DEFAULT CURRENT_DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($conn, $createTableOrder)) {
    echo "Error creating table tb_order: " . mysqli_error($conn);
}

// Membuat tabel tb_product jika belum ada
$createTableProduct = "
CREATE TABLE IF NOT EXISTS tb_product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    product_price DECIMAL(10, 2) NOT NULL,
    product_description TEXT NOT NULL,
    product_image VARCHAR(100),
    product_status TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($conn, $createTableProduct)) {
    echo "Error creating table tb_product: " . mysqli_error($conn);
}

// Membuat tabel tb_admin jika belum ada
$createTableAdmin = "
CREATE TABLE IF NOT EXISTS tb_admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin_email VARCHAR(100) NOT NULL,
    admin_tlp VARCHAR(100) NOT NULL, 
    reset_token VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($conn, $createTableAdmin)) {
    echo "Error creating table tb_admin: " . mysqli_error($conn);
}
?>