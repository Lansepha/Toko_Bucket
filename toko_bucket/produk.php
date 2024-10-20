<?php
session_start();
include 'db.php'; // Memastikan file koneksi database benar

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
                <li><a href="produk.php">Produk</a></li>
            </ul>
        </div> 
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php" method="GET">
                <input type="text" name="search" placeholder="Cari Produk" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>

    <!-- Produk -->
    <div class="section">
        <div class="container">
            <h3>Produk</h3>
            <br>
            <div class="box-beranda">
                <?php
                $search = '';
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                }

                $kategori = '';
                if (isset($_GET['kategori'])) {
                    $kategori = $_GET['kategori'];
                }

                $where = "WHERE product_status = 1";
                if (!empty($search)) {
                    $where .= " AND product_name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
                }
                if (!empty($kategori)) {
                    $where .= " AND categori_id = " . mysqli_real_escape_string($conn, $kategori);
                }

                $produk = mysqli_query($conn, "SELECT * FROM tb_product $where ORDER BY product_id DESC");
                if (mysqli_num_rows($produk) > 0) {
                    while ($p = mysqli_fetch_array($produk)) {
                ?>
                        <a href="detail-produk.php?id=<?php echo $p['product_id']?>">
                            <div class="col-4">
                                <img src="produk/<?php echo $p['product_image']; ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>">
                                <p class="nama"><?php echo htmlspecialchars($p['product_name']); ?></p>
                                <p class="harga">Rp. <?php echo number_format($p['product_price'], 0, ',', '.'); ?></p>
                            </div>
                        </a>
                <?php 
                    } 
                } else { 
                ?>
                    <p>Produk tidak ada</p>
                <?php 
                } 
                ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="footer">
            <div class="container">
                <div class="footer-section">
                    <h4>Alamat</h4>
                    <p>Perum Cengkong Persada, Blok A No. 5, Karawang, Jawa Barat</p>
                </div>
                
                <div class="footer-section">
                    <h4>Email</h4>
                    <p>info@flowerlybucket.com</p>
                </div>
                
                <div class="footer-section">
                    <h4>No. Hp</h4>
                    <p>+62895330191783</p>
                </div>
                
                <div class="footer-section social-media">
                    <h4>Ikuti Kami</h4>
                    <a href="https://www.facebook.com/profile.php?id=61559603363216" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="https://www.instagram.com/flowerlybucket" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="https://www.twitter.com/flowerlybucket" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <small>&copy; 2024 - FlowerlyBucket. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>