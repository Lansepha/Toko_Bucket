<?php
session_start();
include 'db.php';
// Periksa status login 
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
  // Tampilkan pesan  
  echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
  exit; 
}

$kategori = mysqli_query($conn, "SELECT * FROM tb_categori WHERE categori_id = '".$_SESSION['id']."'");
// if(mysqli_num_rows($kategori == 0)){
//     echo '<script>window.location="data-kategori.php"</script>';
// }
$k = mysqli_fetch_object($kategori);

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
      <h3>Edit Data Kategori</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="text" name="nama" placeholder="Nama kategori" class="input-control"value="<?php echo isset($d->categori_name) ? $d->categori_name : '' ?>" required>
          <input type="submit" name="submit" value="Submit" class="btn">
        </form>
        <?php
      if(isset($_POST['submit'])){
        $nama = ucwords($_POST['nama']);

        $update = mysqli_query($conn, "UPDATE tb_categori SET
                                 categori_name = '".$nama."'
                               WHERE categori_id='".$k->categori_id."' ");

        if($update){
            echo '<script>alert("Edit data berhasil")</script>';
            echo '<script>window.location="data-kategori.php"</script>';

        }else{
            echo 'gagal'.mysqli_error($conn);
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