<?php
session_start();

// Periksa status login 
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
  // Tampilkan pesan  
  echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
  exit; 
}

include 'db.php'; // Sertakan file koneksi ke database

// Fungsi untuk mengambil total pendapatan hari ini
function getTotalPendapatanHariIni($conn) {
    $today = date('Y-m-d');
    $query = "SELECT SUM(total_harga) AS total FROM tb_order WHERE tanggal_order = '$today'";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'] ? $row['total'] : 0;
}

// Fungsi untuk mengambil jumlah produk terjual hari ini
function getJumlahProdukTerjualHariIni($conn) {
    $today = date('Y-m-d');
    $query = "SELECT SUM(jumlah) AS total_produk FROM tb_order WHERE tanggal_order = '$today'";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total_produk'] ? $row['total_produk'] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>tokoBucket</title>
    <!-- khusus logo -->
    <style>
        .header-logo {
            display: flex;
            align-items: center;
        }
        .header-logo img {
            height: 50px;
            width: 50px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .header-logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container">
      <h1 class="header-logo">
          <a href="dashboard.php">
              <img src="img/logo.png">
              FlowerlyBucket
          </a>
      </h1> 
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="data-kategori.php">Data Kategori</a></li>
        <li><a href="data-produk.php">Data Produk</a></li>
        <li><a href="data-pelanggan.php">Data Pelanggan</a></li>
        <li><a href="data-order.php">Data Order</a></li>
        <li><a href="keluar.php">Keluar</a></li>
      </ul>
    </div> 
  </header>

  <!-- Content -->
  <div class="section">
    <div class="container">
        <h3>Dashboard</h3>
        <div class="box">
            <h1>Selamat datang di toko online kami, <?php echo $_SESSION['a_global']->admin_name?></h1>
            
            <!-- Statistik Penjualan -->
            <h2>Statistik Penjualan Hari Ini</h2>
            <ul>
                <li>Total Pendapatan Hari Ini: Rp <?php echo number_format(getTotalPendapatanHariIni($conn), 0, ',', '.') ?></li>
                <li>Jumlah Produk Terjual Hari Ini: <?php echo getJumlahProdukTerjualHariIni($conn) ?> produk</li>
            </ul>
        </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
        <small>Copyright &copy; 2024 - FlowerlyBucket.</small>
    </div>
  </footer>

</body>
</html>