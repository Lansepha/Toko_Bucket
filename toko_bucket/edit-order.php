<?php
session_start();
include 'db.php';

// Periksa status login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
    exit;
}

// Periksa apakah ada parameter id yang dikirimkan
if (!isset($_GET['id'])) {
    echo '<p>Parameter ID tidak ditemukan.</p>';
    exit;
}

$order_id = $_GET['id'];

// Ambil data order berdasarkan order_id
$query = "SELECT * FROM tb_order WHERE order_id = '".$order_id."'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo 'Error: ' . mysqli_error($conn);
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo '<p>Order tidak ditemukan.</p>';
    exit;
}

$order = mysqli_fetch_assoc($result);

// Proses update jika form disubmit
if (isset($_POST['submit'])) {
    $new_jumlah = $_POST['jumlah'];

    // Ambil harga produk
    $harga_query = mysqli_query($conn, "SELECT product_price FROM tb_product WHERE product_id = '".$order['product_id']."'");
    if (!$harga_query) {
        echo 'Error: ' . mysqli_error($conn);
        exit;
    }
    $harga_data = mysqli_fetch_array($harga_query);
    $harga = $harga_data['product_price'];

    // Hitung total harga baru
    $new_total_harga = $harga * $new_jumlah;

    // Update jumlah dan total harga berdasarkan order_id
    $update_query = mysqli_query($conn, "UPDATE tb_order SET 
        jumlah = '".$new_jumlah."', 
        total_harga = '".$new_total_harga."' 
        WHERE order_id = '".$order_id."'");

    if ($update_query) {
        echo '<script>alert("Order berhasil diperbarui")</script>';
        echo '<script>window.location="data-order.php"</script>';
    } else {
        echo 'Error: ' . mysqli_error($conn);
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
    <title>Edit Order</title>
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
            <h3>Edit Order</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="number" name="jumlah" placeholder="Jumlah" class="input-control" value="<?php echo $order['jumlah']; ?>" required>
                    <input type="submit" name="submit" value="Update" class="btn">
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