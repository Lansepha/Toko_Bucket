<?php
session_start();
include 'db.php';
// Periksa status login 
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
  // Tampilkan pesan  
  echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
  exit; 
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
    <script src="https://cdn.ckeditor.com/4.24.0-lts/standard/ckeditor.js"></script>
    <title>tokoBucket</title>
    <script src="https://cdn.ckeditor.com/4.24.0-lts/standard/ckeditor.js"></script>
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
      <h3>Tambah Data Produk</h3>
      <div class="box">
        <form action="" method="POST" enctype="multipart/form-data">
          <select class="input-control" name="kategori" required>
                <option value="">--pilih--</option>
                <?php
                $kategori = mysqli_query($conn, "SELECT * FROM tb_categori ORDER BY categori_id DESC");
                while($r = mysqli_fetch_array($kategori)){
                  
                ?>
                <option value="<?php echo $r['categori_id']?>"><?php echo $r['categori_name']?></option>
                <?php } ?>
          </select>
          <input type="text" name="nama" class="input-control" placeholder="Nama Produk" required>
          <input type="text" name="harga" class="input-control" placeholder="Harga" required>
          <input type="file" name="gambar" class="input-control" required>
          <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea><br>
          <select class="input-control" name="status">
            <option value="">--pilih--</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak aktif</option>
          </select>
          <input type="submit" name="submit" value="Submit" class="btn">
        </form>
      <?php
      if(isset($_POST['submit'])){
        // print_r($_FILES['gambar']);
        // Menampung imputan dari form
        $kategori   = $_POST['kategori'];
        $nama       = $_POST['nama'];
        $harga      = $_POST['harga'];
        $deskripsi  = $_POST['deskripsi'];
        $status     = $_POST['status'];

        // Menampung data file yang di upload
        $filename = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        // explode untuk membuat text menjadi array
        $type1 = explode('.', $filename);
        $type2 = $type1[1];

        $newname = 'produk'.time().'.'.$type2;

        echo $type2;
        // Menampung data format file yang di izinkan 
        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

        // Validasi format file
        if(!in_array($type2, $tipe_diizinkan)){
          // Jika format file tidak ada di dalam tipe di izinkan
          echo '<script>alert("Format file tidak diizinkan")</script>';
        }else{
          // Jika formmat file sesuai dengan yang ada di dalam tipe di izinkan
           // Proses upload file sekaligus insert ke database 
           move_uploaded_file($tmp_name, './produk/' . $newname);

           $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES(
                            null,
                            '".$kategori."',
                            '".$nama."',
                            '".$harga."',
                            '".$deskripsi."',
                            '".$newname."',
                            '".$status."',
                            null
            ) ");
            if($insert){
                echo '<script>alert("Input data berhasil")</script>';
                echo '<script>window.location="data-produk.php"</script>';
            }else{
              echo 'Input data gagal'.mysqli_error($conn);
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
  <script>
        CKEDITOR.replace( 'deskripsi' );
  </script>

</body>
</html>