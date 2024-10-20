<?php
session_start();
include 'db.php';

// Periksa status login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
    exit;
}

// Ambil data produk berdasarkan ID
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];
    $result = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '$idp'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo '<p>Data produk tidak ditemukan.</p>';
        exit;
    }
} else {
    echo '<p>ID produk tidak ditemukan.</p>';
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
    <title>Edit Produk</title>
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
            <h3>Edit Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama" placeholder="Nama Produk" class="input-control" value="<?php echo $row['product_name']; ?>" required>
                    <input type="text" name="harga" placeholder="Harga" class="input-control" value="<?php echo $row['product_price']; ?>" required>
                    <img src="produk/<?php echo $row['product_image']; ?>" width="100px">
                    <input type="file" name="gambar" class="input-control">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="input-control" required><?php echo $row['product_description']; ?></textarea>
                    <select name="status" class="input-control">
                        <option value="">--Pilih--</option>
                        <option value="1" <?php echo ($row['product_status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                        <option value="0" <?php echo ($row['product_status'] == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $nama = $_POST['nama'];
                    $harga = $_POST['harga'];
                    $deskripsi = $_POST['deskripsi'];
                    $status = $_POST['status'];
                    $gambar = $_FILES['gambar']['name'];

                    // Handle file upload
                    if ($gambar != '') {
                        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                        $filename = $_FILES['gambar']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);

                        if (!in_array($ext, $allowed_types)) {
                            echo '<script>alert("Jenis file tidak diizinkan")</script>';
                        } else {
                            // Remove old image
                            if (file_exists('produk/'.$row['product_image'])) {
                                unlink('produk/'.$row['product_image']);
                            }

                            // Upload new image
                            $newname = 'produk'.time().'.'.$ext;
                            move_uploaded_file($_FILES['gambar']['tmp_name'], 'produk/'.$newname);

                            $gambar_update = ", product_image = '$newname'";
                        }
                    } else {
                        $gambar_update = '';
                    }

                    $update = mysqli_query($conn, "UPDATE tb_product SET 
                        product_name = '$nama',
                        product_price = '$harga',
                        product_description = '$deskripsi',
                        product_status = '$status'
                        $gambar_update
                        WHERE product_id = '$idp'
                    ");

                    if ($update) {
                        echo '<script>alert("Edit data berhasil")</script>';
                        echo '<script>window.location="data-produk.php"</script>';
                    } else {
                        echo 'Error updating product: ' . mysqli_error($conn);
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <small>Hak Cipta &copy; 2024 - FlowerlyBucket</small>
        </div>
    </footer>
</body>
</html>