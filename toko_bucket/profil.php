<?php
session_start();
include 'db.php';

// Periksa status login 
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
  // Tampilkan pesan  
  echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
  exit; 
}

$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '".$_SESSION['id']."'");
$d = mysqli_fetch_object($query);
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
              <img src="img/logo.png" >
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
      <h3>Profil</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="text" name="nama" placeholder="Nama lengkap" class="input-control" value="<?php echo isset($d->admin_name) ? $d->admin_name : '' ?>"  required>
          <input type="text" name="user" placeholder="Username" class="input-control"  value="<?php echo isset($d->username) ? $d->username : '' ?>"  required>
          <input type="text" name="hp" placeholder="No Hp" class="input-control"  value="<?php echo isset($d->admin_tlp) ? $d->admin_tlp : '' ?>"  required>
          <input type="text" name="email" placeholder="Email" class="input-control" value="<?php echo isset($d->admin_email) ? $d->admin_email : '' ?>"  required>
          <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo isset($d->admin_address) ? $d->admin_address : '' ?>" required>
          <input type="submit" name="submit" value="Ubah Profil" class="btn">
        </form>
        <?php
          if(isset($_POST['submit'])){
            $nama   = ucwords($_POST['nama']);
            $user   = $_POST['user'];
            $hp     = $_POST['hp'];
            $email  = $_POST['email'];
            $alamat = ucwords($_POST['alamat']);

            $update = mysqli_query($conn, "UPDATE tb_admin SET 
                                          admin_name      = '".$nama."' ,
                                          username        = '".$user."' ,
                                          admin_tlp       = '".$hp."' ,
                                          admin_email     = '".$email."' ,
                                          admin_address   = '".$alamat."' 
                                          WHERE admin_id  = '".$_SESSION['id']."' ");
            if($update){
              echo '<script>alert("Ubah data berhasil")</script>';
              echo '<script>window.location="profil.php"</script>';
            }else {
              echo '<script>alert("Ubah data gagal")</script>'.mysqli_error($conn);
            }
          }
        ?> 
      </div>
      <h3>Ubah Password</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="password" name="pass1" placeholder="Password baru" class="input-control" required>
          <input type="password" name="pass2" placeholder="Konfirmasi password baru" class="input-control" required>
          <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
        </form>
        <?php
          if(isset($_POST['ubah_password'])){
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            if($pass2 != $pass1){
              echo '<script>alert("Konfirmasi password baru tidak sesuai")</script>';
            }else{
              $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
              $u_pass = mysqli_query($conn, "UPDATE tb_admin SET 
                                              password = '".$hashed_password."' 
                                              WHERE admin_id = '".$_SESSION['id']."' ");
              if($u_pass){
                echo '<script>alert("Ubah password berhasil")</script>';
                echo '<script>window.location="profil.php"</script>';
              }else{
                echo '<script>alert("Ubah password gagal")</script>'.mysqli_error($conn);
              }
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