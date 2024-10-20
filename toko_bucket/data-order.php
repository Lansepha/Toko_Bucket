<?php
session_start();
include 'db.php';

// Periksa status login 
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
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
    <title>Data Order - FlowerlyBucket</title>
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
        <h3>Data Order</h3>
        <div class="box">
            <p><a href="tambah-order.php">Tambah Order</a></p>
            <br>
            <table border="1" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal Order</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        $order = mysqli_query($conn, "
                            SELECT o.order_id, p.pelanggan_name, pr.product_name, o.jumlah, o.total_harga, o.tanggal_order 
                            FROM tb_order o
                            JOIN tb_pelanggan p ON o.pelanggan_id = p.pelanggan_id
                            JOIN tb_product pr ON o.product_id = pr.product_id
                            ORDER BY o.order_id DESC
                        ");
                        while($row = mysqli_fetch_array($order)) {
                    ?>
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $row['pelanggan_name']?></td>
                        <td><?php echo $row['product_name']?></td>
                        <td><?php echo $row['jumlah']?></td>
                        <td><?php echo $row['total_harga']?></td>
                        <td><?php echo $row['tanggal_order']?></td>
                        <td>
                        <a href="edit-order.php?id=<?php echo $row['order_id']?>">Edit</a> || 
                        <a href="proses-hapus.php?idorder=<?php echo $row['order_id']?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
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