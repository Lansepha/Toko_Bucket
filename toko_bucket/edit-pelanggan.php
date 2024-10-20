<?php
session_start();
include 'db.php';

// Periksa status login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    // Tampilkan pesan
    echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
    exit;
}

// Periksa apakah ID pelanggan telah dikirim melalui URL
if (!isset($_GET['id'])) {
    echo '<p>ID pelanggan tidak ditemukan. <a href="data-pelanggan.php">Kembali ke Data Pelanggan</a></p>';
    exit;
}

$id_pelanggan = $_GET['id'];

// Ambil data pelanggan berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE pelanggan_id = '".$id_pelanggan."'");
if (mysqli_num_rows($query) == 0) {
    echo '<p>Data pelanggan tidak ditemukan. <a href="data-pelanggan.php">Kembali ke Data Pelanggan</a></p>';
    exit;
}
$data = mysqli_fetch_assoc($query);

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
    <title>Edit Data Pelanggan</title>
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
      <h3>Edit Data Pelanggan</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="text" name="nama" placeholder="Nama Pelanggan" class="input-control" value="<?php echo $data['pelanggan_name']; ?>" required>
          <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $data['pelanggan_email']; ?>" required>
          <input type="text" name="telepon" placeholder="Telepon" class="input-control" value="<?php echo $data['pelanggan_phone']; ?>" required>
          <textarea name="alamat" placeholder="Alamat" class="input-control" required><?php echo $data['alamat']; ?></textarea>
          <input type="submit" name="submit" value="Update" class="btn">
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $nama = ucwords($_POST['nama']);
            $email = $_POST['email'];
            $telepon = $_POST['telepon'];
            $alamat = $_POST['alamat'];

            $update = mysqli_query($conn, "UPDATE tb_pelanggan SET 
                pelanggan_name = '".$nama."', 
                pelanggan_email = '".$email."', 
                pelanggan_phone = '".$telepon."', 
                alamat = '".$alamat."' 
                WHERE pelanggan_id = '".$id_pelanggan."'");

            if ($update) {
                echo '<script>alert("Update data berhasil")</script>';
                echo '<script>window.location="data-pelanggan.php"</script>';
            } else {
                echo 'Gagal '.mysqli_error($conn);
            }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <small>Copyright &copy; 2024 - FlowerlyBucket</small>
    </div>
  </footer>

</body>
</html>