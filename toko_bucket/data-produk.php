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
<body >
  <!-- Header -->
  <Header>
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
        <li><a href="data-kategori.php">Data Ketegori</a></li>
        <li><a href="data-produk.php">Data Produk</a></li>
        <li><a href="data-pelanggan.php">Data Pelanggan</a></li>
        <li><a href="data-order.php">Data Order</a></li>
        <li><a href="keluar.php">Keluar</a></li>
    </ul>
    </div> 
  </Header>


  <!-- Content -->
  <div class="section">
    <div class="container">
        <h3>Data Produk</h3>
        <div class="box">
            <p><a href="tambah-produk.php">Tambah Produk</a></p>
            <br>
            <table border="1" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th width="50">Gambar</th>
                        <th>Status</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        $produk = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_categori USING (categori_id) ORDER BY product_id DESC");
                        if(mysqli_num_rows($produk) > 0){

            
                        while($row = mysqli_fetch_array($produk)) {
                    ?>
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $row['categori_name']?></td>
                        <td><?php echo $row['product_name']?></td>
                        <td>Rp.<?php echo number_format($row['product_price']) ?></td>
                        <td><?php echo $row['product_description']?></td>
                        <td><img src="produk/<?php echo $row['product_image']?>" width="50px"></td>
                        <td><?php echo ($row['product_status'] == 0)? 'Tidak aktif':'Aktif';?></td>
                        <td><a href="edit-produk.php?idp=<?php echo $row['product_id']?>">Edit</a> || <a href="proses-hapus.php?idp=<?php echo $row['product_id']?>" onclick="return confirm('Yakin ingin hapus')">Hapus</a></td>
                    </tr>
                    <?php }} else {?>
                        <tr>
                            <td colspan="8">Data Kosong</td>
                        </tr>
                        <?php }?>
                </tbody>
            </table>
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