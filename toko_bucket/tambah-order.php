<?php
session_start();
include 'db.php';

// Periksa status login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
    exit;
}

if (isset($_POST['submit'])) {
    $pelanggan_id = $_POST['pelanggan'];
    $product_id = $_POST['produk'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga produk
    $harga_query = mysqli_query($conn, "SELECT product_price FROM tb_product WHERE product_id = '".$product_id."'");
    if (!$harga_query) {
        echo 'Error: ' . mysqli_error($conn);
        exit;
    }
    $harga_data = mysqli_fetch_array($harga_query);
    $harga = $harga_data['product_price'];

    // Hitung total harga
    $total_harga = $harga * $jumlah;

    // Cek apakah product_id sudah ada di tb_order
    $check_query = mysqli_query($conn, "SELECT * FROM tb_order WHERE product_id = '".$product_id."'");
    if (mysqli_num_rows($check_query) > 0) {
        // Jika produk sudah ada, update jumlah dan total harga
        $existing_order = mysqli_fetch_assoc($check_query);
        $new_jumlah = $existing_order['jumlah'] + $jumlah;
        $new_total_harga = $existing_order['total_harga'] + $total_harga;

        $update_query = mysqli_query($conn, "UPDATE tb_order SET 
            jumlah = '".$new_jumlah."', 
            total_harga = '".$new_total_harga."' 
            WHERE product_id = '".$product_id."'");

        if ($update_query) {
            echo '<script>alert("Order berhasil diperbarui")</script>';
            echo '<script>window.location="data-order.php"</script>';
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        // Jika produk belum ada, tambahkan baru ke tb_order
        $insert = mysqli_query($conn, "INSERT INTO tb_order (pelanggan_id, product_id, jumlah, total_harga, tanggal_order) VALUES ( 
            '".$pelanggan_id."',
            '".$product_id."',
            '".$jumlah."',
            '".$total_harga."',
            '".date('Y-m-d')."'
        )");

        if ($insert) {
            echo '<script>alert("Tambah order berhasil")</script>';
            echo '<script>window.location="data-order.php"</script>';
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
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
    <title>Tambah Order</title>
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
            <h3>Tambah Order</h3>
            <div class="box">
                <form action="" method="POST">
                    <select name="pelanggan" class="input-control" required>
                        <option value="">--Pilih Pelanggan--</option>
                        <?php
                        $pelanggan = mysqli_query($conn, "SELECT * FROM tb_pelanggan ORDER BY pelanggan_id DESC");
                        while ($r = mysqli_fetch_array($pelanggan)) {
                            echo '<option value="'.$r['pelanggan_id'].'">'.$r['pelanggan_name'].'</option>';
                        }
                        ?>
                    </select>
                    <select name="produk" class="input-control" required>
                        <option value="">--Pilih Produk--</option>
                        <?php
                        $produk = mysqli_query($conn, "SELECT * FROM tb_product ORDER BY product_id DESC");
                        while ($p = mysqli_fetch_array($produk)) {
                            echo '<option value="'.$p['product_id'].'">'.$p['product_name'].'</option>';
                        }
                        ?>
                    </select>
                    <input type="number" name="jumlah" placeholder="Jumlah" class="input-control" required>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
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